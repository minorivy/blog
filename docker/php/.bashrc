#!/bin/bash
alias l='ls -a'
alias ll='ls -la'
alias v='vim'
alias ..='cd ../'

git config --global alias.pl "pull origin"; \
git config --global alias.b branch; \
git config --global alias.p push; \
git config --global alias.ch checkout; \
git config --global alias.m "merge --no-ff --no-edit"; \
git config --global alias.c "commit"; \
git config --global alias.l "log --graph --decorate"; \
git config --global alias.st "status -s"; \
git config --global alias.pick "cherry-pick -n";