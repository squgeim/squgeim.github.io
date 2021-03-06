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

.DEFAULT_GOAL := all
.PHONY: clean

all: $(BLOG_DEST_FILES) $(PAGE_DEST_FILES)
	@./update_service_worker.sh $^

clean:
	-rm $(BLOG_DEST_FILES) $(PAGE_DEST_FILES)

$(PAGE_DEST_DIR)/%.html: $(PAGE_SRC_DIR)/%.php $(FRAGMENTS_FILES)
	php $< > $@

$(PAGE_DEST_DIR)/index.html: $(BLOG_SRC_FILES)

$(BLOG_DEST)/%.html: $(BLOG_SRC)/%.md $(FRAGMENTS_FILES)
	php $(BLOG_SRC)/blog.php $< > $@
