<Blog
  title="Regrets in a 1-year-old React project"
  publishedDate="2018-03-27"
  url="https://dev.to/squgeim/regrets-in-a-1-year-old-react-project-4j7j"
  tags="javascript-framework,redux,react,material-ui"
>
The JavaScript ecosystem has become scary. There are over 600,000 packages in NPM to choose from, with over 600 added every day, and the “best practices” are challenged and replaced by the hot new thing at an alarming rate.

It is natural to want to avoid jumping on every new thing and choose what is needed when starting a new project. That is what we did when we started out on a project.

These are the things we regret doing or not-doing from the get-go.
</Blog>


The JavaScript ecosystem has become scary. There are over 600,000 packages in NPM to choose from, with over 600 added every day, and the “best practices” are challenged and replaced by the hot new thing at an alarming rate.

It is natural to want to avoid jumping on every new thing and choose what is needed when starting a new project. That is what we did when we started out on a project.

These are the things we regret doing or not-doing from the get-go:

### **1. Not Using Selectors**

We should have never touched the Redux Store without a [selector](https://stackoverflow.com/questions/38674200/what-are-selectors-in-redux). The reasoning was simple at the beginning: if you need specialized methods to extract data from your store, your store is too complicated. Simplify that instead; hiding that complexity will only fester it.

But we failed to see the other reason why having selectors is essential (and I feel this is not advertised enough): refactoring. Accept it — the store you have designed right now is not the store you will be using a year from now. Requirements change, designs change, new features are added, features are removed; software evolves, and your store needs to evolve with it.

Turns out, having a single interface that defines exactly what is required out of the store makes refactoring simple. The view (even your container components) do not need to know how things are structured in the store, all they care about is what data they receive.

Also, it becomes effortless to write unit tests. As long as the selector returns the same data, you can change the store all you like.

### **2. Not writing PropTypes for Recompose HOC chains**

We heavily use Recompose. Our presentational components are wrapped with a composed chain of Recompose HOCs that build the container component. They were very simple at the beginning; just a Redux connect and a couple of withProps and withHandlers.

The HOC chain looks incredible, data flows down like a waterfall, but happens when you move things around? It is very easy to lose track of what flows where. You could remove or change a prop in one HOC, and not realize some other HOC several components down depended on it.

An easy way to get around this is to define clear [PropTypes](https://reactjs.org/docs/typechecking-with-proptypes.html) (or use a type system like Flow or TypeScript) for each HOC. Writing PropTypes on components come easy, and [most linters check for this](https://github.com/yannickcr/eslint-plugin-react), but writing PropTypes on Recompose HOCs are not that intuitive and, as far as I know, there are no lint rules to check for it. [There is no clear best practice for it yet](https://github.com/acdlite/recompose/issues/592). This just has to be a project convention and needs to be enforced in peer code review.

### **3. Ceding too much control to a library**

“We’re just building a quick MVP to get going. We don’t need to spend much time with fancy designs, let’s just use a popular component library” — that’s how most projects start, and before you know it you are serving thousands of users and guess what, a fancy design becomes a must have.

We started the project with [Material UI](http://www.material-ui.com/#/). It was awesome. You have every component you’ll ever need, you have fancy animations and it is easy to build with. Then, we outgrew our “MVP” phase. We have new complex features that can’t be done with the simple Material UI components. The small performance costs of using inline style start adding up.

Then, the version of Material UI we were using got discontinued. The new version would be a rewrite and would bring much needed performance improvements. All the issues in GitHub for the older version of Material UI [were closed](https://github.com/mui-org/material-ui/issues?q=label%3Av0.x+is%3Aclosed).

So we have a relatively large application that is stuck with an old library, with performance issues, that can’t update to the latest version of React.

What could we do? Either stop everything and upgrade to the newer version. But what about all the components that were dropped in the new version? Find new components to replace them and refactor our code to work with those? Or just drop Material UI and write custom components for everything?

We can’t afford to do either of them. We plan to refactor the code in phases to remove larger dependencies, and once it is simple enough, we’ll upgrade to the newer version (once it comes out of beta, that is).

### **4. Not using CSS-in-JS**

As I said, we started with Material UI, and that was enough for us. We rarely had to customize any of the components, and whenever we needed to, we followed the official advice and used inline styles (this is because Material UI internally uses inline styles).

Also, I advocate the horizontal separation of concerns that React proposes and do not like having one component broken down into multiple files (separate CSS and JS files).

The reason we didn’t have CSS-in-JS from the beginning is that we didn’t need it at the time, and whatever little performance cost we added with inline styles was still shadowed by what Material UI was doing. It was also because the CSS-in-JS community conflicted a few ways of doing things and a de facto library had not yet appeared (still hasn’t).

Now that we are migrating away from Material UI and building more UI by-hand, this is becoming more of an issue. We are currently just using CSS because that’s what everyone is comfortable with, but we are increasingly dividing the CSS for each component to make a clear path for future migration to CSS-in-JS.

### Final Words

This list is not meant to be an exhaustive list of things to look out for when starting a React project. I’m sure there are plenty of them on the web already. These are the points I don’t see often and have been the most painful for us.
