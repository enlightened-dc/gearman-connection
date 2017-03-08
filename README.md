# gearman-connection

[![No Maintenance Intended](http://unmaintained.tech/badge.svg)](http://unmaintained.tech/)

A simple and clean library to get informations from your [gearman](http://gearman.org/) jobserver.

## Minimal example usage:

    require_once __DIR__ . '/../vendor/autoload.php';
    
    use TM\Gearman as Gearman;
    
    $connection = new Gearman\Connection();
    $response = $connection->send(new Gearman\Request('status'));
    
    // Do something with the response ...
    echo $response;

## Customize

If you don't use the default values:
    
    $connection = new Gearman\Connection(
        ['host' => 'my.gearman.host, 'port' => 1234]
    );

And if you don't want an auto-connect by default:

    $connection = new Gearman\Connection(
        ['host' => 'my.gearman.host, 'port' => 1234], 
        false
    );
    ...
    $connection->connect();
    ...

## Contributing

Please refer to [CONTRIBUTING.md](CONTRIBUTING.md) for information on how to contribute.
