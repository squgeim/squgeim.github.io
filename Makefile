SRC_DIR := ./src
DEST_DIR := .
SRC_FILES := $(wildcard $(SRC_DIR)/*.php)
DEST_FILES := $(patsubst $(SRC_DIR)/%.php,$(DEST_DIR)/%.html,$(SRC_FILES))

BLOG_SRC := ./src/content
BLOG_DEST := ./blogs
BLOG_SRC_FILES := $(wildcard $(BLOG_SRC)/*.md)
BLOG_DEST_FILES := $(patsubst $(BLOG_SRC)/%.md,$(BLOG_DEST)/%.html,$(BLOG_SRC_FILES))

$(DEST_DIR)/%.html: $(SRC_DIR)/%.php
	php $< > $@

$(BLOG_DEST)/%.html: $(BLOG_SRC)/%.md
	php $(BLOG_SRC)/blog.php $< > $@

main: $(DEST_FILES) $(BLOG_DEST_FILES)
