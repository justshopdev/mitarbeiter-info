
.PHONY: codefix
codefix:
	ddev exec vendor/bin/php-cs-fixer --allow-risky=yes fix
	ddev exec vendor/bin/twig-cs-fixer lint --fix templates/