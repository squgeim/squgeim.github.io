PAGE_SRC_DIR := ./src/pages
PAGE_DEST_DIR := .
PAGE_SRC_FILES := $(wildcard $(PAGE_SRC_DIR)/*.php)
PAGE_DEST_FILES := $(patsubst $(PAGE_SRC_DIR)/%.php,$(PAGE_DEST_DIR)/%.html,$(PAGE_SRC_FILES))

BLOG_SRC := ./src/content
BLOG_DEST := ./blogs
BLOG_SRC_FILES := $(wildcard $(BLOG_SRC)/*.md)
BLOG_DEST_FILES := $(patsubst $(BLOG_SRC)/%.md,$(BLOG_DEST)/%.html,$(BLOG_SRC_FILES))

$(PAGE_DEST_DIR)/%.html: $(PAGE_SRC_DIR)/%.php
	php $< > $@

$(BLOG_DEST)/%.html: $(BLOG_SRC)/%.md
	php $(BLOG_SRC)/blog.php $< > $@

main: $(PAGE_DEST_FILES) $(BLOG_DEST_FILES)
