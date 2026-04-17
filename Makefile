PAGE_SRC_DIR := ./src/pages
PAGE_DEST_DIR := .
PAGE_SRC_FILES := $(wildcard $(PAGE_SRC_DIR)/*.php)
PAGE_DEST_FILES := $(patsubst $(PAGE_SRC_DIR)/%.php,$(PAGE_DEST_DIR)/%.html,$(PAGE_SRC_FILES))

BLOG_SRC := ./src/content
BLOG_DEST := ./blogs
BLOG_SRC_FILES := $(wildcard $(BLOG_SRC)/*.md)
BLOG_DEST_FILES := $(patsubst $(BLOG_SRC)/%.md,$(BLOG_DEST)/%.html,$(BLOG_SRC_FILES))

FRAGMENTS_DIR := ./src/fragments
FRAGMENTS_FILES := $(wildcard $(FRAGMENTS_DIR)/*.php)

PORT := 8080

.DEFAULT_GOAL := all
.PHONY: clean serve docker-build docker-clean docker-serve

all: $(BLOG_DEST_FILES) $(PAGE_DEST_FILES)
	@./update_service_worker.sh $^

clean:
	-rm $(BLOG_DEST_FILES) $(PAGE_DEST_FILES)

$(PAGE_DEST_DIR)/%.html: $(PAGE_SRC_DIR)/%.php $(FRAGMENTS_FILES)
	php $< > $@

$(PAGE_DEST_DIR)/index.html: $(BLOG_SRC_FILES)

$(BLOG_DEST)/%.html: $(BLOG_SRC)/%.md $(FRAGMENTS_FILES)
	php $(BLOG_SRC)/blog.php $< > $@

DOCKER_IMAGE := php:8.3-cli
DOCKER_RUN := docker run --rm -v "$(CURDIR):/app" -w /app $(DOCKER_IMAGE)
.PHONY: docker-build docker-clean docker-serve dev
docker-build:
	$(DOCKER_RUN) make

docker-clean:
	$(DOCKER_RUN) make clean

docker-serve: docker-build
	docker run --rm -v "$(CURDIR):/app" -w /app -p $(PORT):$(PORT) $(DOCKER_IMAGE) \
		php -S 0.0.0.0:$(PORT)

serve: docker-build
	@echo "Serving at http://localhost:$(PORT)"
	python3 -m http.server $(PORT) --directory "$(CURDIR)"

dev:
	docker compose up --build
