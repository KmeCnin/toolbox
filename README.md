# Toolbox
Various set of helpful methods, classes, etc.

## LifeTimeBehaviour
Inject a LifeTime object in an object implementing HasLifeTimeInterface in order to easily handle an expirable behaviour.

## GetBootstrapForSymfony2
Provide some form template in order to render the [Bootstrap](http://getbootstrap.com/) theme. Given template add 2 more fields type than the default bootstrap_3_layout.html.twig provided by Symfony 2.6:
- `datepicker`: provide a popup where you can pick easily a date up in the bootstrap style
- `datetimepicker`: use the `datepicker` template adding an input for the time

## OptionalPattern
This helper is useful in order to strip optionals characters from an input string and keep only the part you want.  

*For example* we could have an input trying to match a twitter username from url, like `twitter.com/Foo`, `Foo/status` or `twitter.com/Foo/status`.  
But we only want to keep the *username*. So we define `https://twitter.com/` as the **prefix** before the username and `/status/` as the **suffix** after the username. After applying `stripPrefix` and `stripSuffix`, we can get the stripped result which should be the username if the input was conform to twitter url pattern.
