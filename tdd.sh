php -d auto_prepend_file=loader.php -d auto_append_file=runner.php -d include_path=":src/main/php:target/phpinc:src/test/php" "src/test/php/UnitTestSuite.php"
