# Toolbox
Various set of helpful methods, classes, etc.

## LifeTimeBehaviour
Inject a LifeTime object in an object implementing HasLifeTimeInterface in order to easily handle an expirable behaviour.

## GetBootstrapForSymfony2
Provide some form template in order to render the [Bootstrap](http://getbootstrap.com/) theme. Given template add 2 more fields type than the default bootstrap_3_layout.html.twig provided by Symfony 2.6:
- `datepicker`: provide a popup where you can pick easily a date up in the bootstrap style
- `datetimepicker`: use the `datepicker` template adding an input for the time
