# html

## Description
A simple way to create html element

## How to use
```php
echo html("a")->href("https://google.com")->text("Hello world!");
//<a href="https://google.com">Hello world</a>


echo html("div")->button->class("btn btn-xs")->type("submit")->text("Submit");
//<div><button class="btn btn-xs" type="submit">Submit</button></div>
```




