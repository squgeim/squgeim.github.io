<Blog
  title="Unit Testing Recompose HOCs"
  publishedDate="2018-01-08"
  url="https://dev.to/squgeim/unit-testing-recompose-hocs-3nh4"
  tags="javascript,react,unit-testing,recompose"
>
I am a huge fan of [recompose](https://github.com/acdlite/recompose). It lets us write pure, functional, “dumb” components, by allowing us to dump all the logic inside any of the huge collection of HOCs it provides. It’s awesome.

I’ve been using this a lot and there’s this thing that has always been bugging me: how do you test them, _properly_?
</Blog>


I am a huge fan of [recompose](https://github.com/acdlite/recompose). It lets us write pure, functional, “dumb” components, by allowing us to dump all the logic inside any of the huge collection of HOCs it provides. It’s awesome.

I’ve been using this a lot and there’s this thing that has always been bugging me: how do you test them, _properly_?

On one hand, since the components become truly pure, a bunch of snapshot tests for the different combination of props pretty much covers them.

Simple tests for mapStateToProps, mapStateToDispatch and mergeProps covers connect.

When it comes to an HOC, it gets a little tricky.

One route would be to do a regular snapshot test for the final component that is actually rendered. But isn’t that repeating the tests we wrote for the pure components? Since we know that they behave properly for a given set of props, we don’t really need to worry about them.

The most common use case of an HOC, from what I have personally seen, is that it takes an input from the props, fetches new information or somehow transforms that input and includes the output as props to the next component.

Hence, if we only need to test the behavior of the HOC, what we really care is what set of props it returns for a given set of input props. Or, in case of a redux-based application, what set of actions it dispatches for a given set of input (I haven’t really thought this through for a non-redux application).

Imagine a component that greets the user with the day and weather.

> _Hello, John! It is a sunny sunday!_

Better yet, lets write it:

```jsx
import React from 'react';
import { compose, withProps } from 'recompose';

import { getFirstName } from '../utils/name';
import { getDayFromDate } from '../utils/date';
import { getHumanReadableWeather } from '../utils/weather';

const Greeter = ({ firstName, day, weather }) => (
  <div>
      Hello, {firstName}! It is a {weather} {day}!
  </div>
);

/**
 * This HOC takes a more crude version of currentUser, date and
 * weather data and maps them to a version that is easily
 * used in the component. That way, the end component is not
 * dependent on the implementation detail or API response format
 * for these information.
 */
export const enhance = compose(
  withProps(props => ({
    firstName: getFirstName(props.currentUser.name),
    day: getDayFromDate(props.date),
    weather: getHumanReadableWeather(props.weather)
  }))
);

export default enhance(Greeter);
```

What we need to test now is whether or not the enhancer returns the correct props.

_\<sidenote\> This may look like a trivial thing to test. The point is, when doing TDD, the tests are written first and we can't (in most cases) forsee how complicated the implementation will get._ _\</sidenote\>_

If I didn’t know any better and was forced into writing a test for it, it’d be something like this:

```jsx
import React from 'react';
import renderer from 'react-test-renderer';

import Greeter from './greeter';

const weatherData = {
  weather: [{
    id: 804,
    main: "clouds",
    description: "overcast clouds",
    icon: "04n"
  }],
  main: {
    temp: 289.5,
    humidity: 89,
    pressure: 1013,
    temp_min: 287.04,
    temp_max: 292.04
  },
  wind: {
    speed: 7.31,
    deg: 187.002
  },
  rain: {
    '3h': 0
  },
  clouds: {
    all: 92
  },
};

it('should render a component with props name, day and weather', () => {
  const greeter = renderer.create(
    <Greeter
      currentUser={{ name: 'Shreya Dahal' }}
      date={new Date(1514689615530)}
      weather={weatherData}
    />
  ).toJSON();

  expect(greeter).toMatchSnapshot();
});
```
Good ‘ol [snapshot testing](https://facebook.github.io/jest/docs/en/snapshot-testing.html).

There are many problems with this.

One, we are dependent on what is rendered to infer what our enhancer returned. It just doesn’t sit well with me that we are infering the validity of our logic from a secondary source. A major concern is that the component we rendered may not use all the props passed. This is an issue because the purpose of an HOC is that it could be reused in multiple components; we would have to test the same HOC with multiple components to see the whole picture.

Two, we can’t do TDD this way. Snapshot testing works for components because we don’t really TDD a view, but writing logic is where TDD shines.

One fine evening, I was lazily browsing through [recompose’s API docs](https://github.com/acdlite/recompose/blob/master/docs/API.md) and saw a method that brought out fantasies in my head. The createSink method:

```
createSink(callback: (props: Object) => void): ReactClass
```

> Creates a component that renders nothing (null) but calls a callback when receiving new props.

This factory function takes a callback and returns a component that renders nothing but calls the callback every time it receives any props. So if this sink component is enhanced with an HOC, the callback can tell us exactly what props the HOC has passed in.

So we can do something like this to test just the enhancer in the Greeter example above:

```jsx
import React from 'react';
import renderer from 'react-test-renderer';
import { createSink } from 'recompose';

import { enhance } from './greeter';

it('should render a component with props name, day and weather', () => {
  const sink = createSink(props => {
    // This callback will be called for each set of props passed to the sink
    // We can use `toMatchObject` to test if the given key-value pairs are
    // present in the props object.
    expect(props).toMatchObject({
      name: 'Shreya',
      day: 'sunday',
      weather: 'cloudy',
    });
  });
  
  const EnhancedSink = enhance(sink);

  renderer.create(
    <EnhancedSink
      currentUser={{
        name: 'Shreya Dahal',
      }}
      date={new Date(1514689615530)}
      weather={weatherData}
    />
  );
});
```

A simple data in, data out. TDD away!

Now on to HOCs with side effects: HOCs that dispatch actions in their lifecycle.

So there’s an HOC that fetches a given contact and includes it in the props to be consumed down the line:

```jsx
import React from 'react';
import { connect } from 'react-redux';
import { compose, lifecycle } from 'recompose';

// You'd probably have a proper selector instead
const getContactById = (state, id) => id && state.contacts[id] || {};

const withContact = compose(
  connect(
    (state, props) => ({
      contact: getContactById(state, props.contactId),
    }),
    dispatch => ({
      fetchContact(id) {
        dispatch(contactActions.fetchContact(id))
      },
    })
  ),
  lifecycle({
    componentDidMount() {
      // Fetch details for the given contactId on mount.
      this.props.fetchContact(this.props.contactId);
    },
    componentWillReceiveProps(nextProps) {
      // Fetch details for the new contactId if the contactId prop has changed.
      if (nextProps.contactId !== this.props.contactId) {
        this.props.fetchContact(nextProps.contactId);
      }
    }
  })
);

export default withContact;
```

How do we go about testing this?

If we need to use connect, it will need to have been wrapped in a Provider with a store. We can use [redux-mock-store](https://github.com/arnaudbenard/redux-mock-store) for that. Then, we can easily extract out a list of all the actions that have been dispatched to the mock store.

Testing actions dispatched in componentDidMount is simple:

```jsx
import React from 'react';
import renderer from 'react-test-renderer';
import configureStore from 'redux-mock-store';
import { Provider, connect } from 'react-redux';

import withContact from './withContact';
import * as contactActions from '../actions/contactActions';

const mockStore = configureStore([]);

// Component that renders nothing. Used as the end point of an HOC.
const NullComponent = () => null;

it('should dispatch a FETCH_CONTACT action on mount', () => {

  const store = mockStore({});
  
  const EnhancedSink = withContact(NullComponent);

  renderer.create(
    <Provider store={store}>
      <EnhancedSink contactId={214} />
    </Provider>
  );

  expect(store.getActions()).toContainEqual(
    contactActions.fetchContact(214)
  );
});
```

Testing componentWillReceiveProps is similar. We can use react-test-renderer's testInstance.update method to rerender the root component with different props, and it will do the right thing: call componentDidMount for new components and componentWillReceiveProps for old components.

```jsx
it('should fetch a new contact when prop is changed', () => {
  const store = mockStore({});

  const EnhancedSink = withContact(NullComponent);

  const RootComponent = ({ id }) => (
    <Provider store={store}>
      <EnhancedSink contactId={id} />
    </Provider>
  );

  // First mount the component with first props
  const renderInstance = renderer.create(<RootComponent id={123} />);

  // Clear actions that may have been dispatched during mount.
  store.clearActions();

  // Then, change the props
  renderInstance.update(<RootComponent id={456} />);

  expect(store.getActions()).toContainEqual(
    contactActions.fetchContact(456)
  );
});
```

Nice.

This may seem like a lot of code to test just two lifecycle methods, but these have been deliberately separated like this. The didMount and willReceiveProps tests can go into the same test suite (describe block) and can probably use the same store, EnhancedSink and RootComponent. That would also largely simplify the willReceiveProps block. What I'm saying is there are ways you can do it simpler.

Either way, a little more time and effort put into writing tests (while the code is simpler, or better yet, when the code isn’t even there) can go a long way and is worth it.
