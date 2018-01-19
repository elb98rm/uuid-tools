# Usage

The UUID tools class offers several quick and easy methods to quickly create and manipulate UUIDs. 

## Class instantiation

Instantiate the class as required.

`$uuid_tools = new \Floor9design\UuidTools\UuidTools();`

or

`Use \Floor9design\UuidTools\UuidTools;`

and 

`$uuid_tools = new UuidTools();`

## Creating a UUID

The `create` function will generate a new UUID:

`$uuid = $uuid_tools->create()`

It optionally takes a machine id/MAC address (string):

`$uuid = $uuid_tools->create($machine_id)`

If none is provided, this will auto generate using `floor9design/machine-tools`.
 
The object generated is a `webpatser/laravel-uuid` so has access to all the relevant methods. See their 
[documentation](https://github.com/webpatser/laravel-uuid/blob/master/readme.md) for more information. 

However, one of the main points of this package is quick and easy UUID inline generation and manipulation. There are 
two ways to create ids inline: id, and id_text.

### Binary 16 string

The following creates a binary 16 string

    $uuid_tools->createId()
    // returns a binary(16), suitable for database interaction such as a primary key 

### Hexadecimal string

The following creates a hexadecimal string, optionally taking a boolean switch to miss out dashes

    $uuid_tools->createIdText()
    // returns a UUID of the form: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
    // eg: 123e4567-e89b-12d3-a456-426655440000
    
    $uuid_tools->createIdText(false)
    // returns a UUID of the form: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
    // eg: 123e4567e89b12d3a456426655440000

### Conversion

To convert between the two types, two methods are implemented:

    // convert a hexadecimal string to a binary string:
    $id = $uuid_tools->idToIdText($id_text)
    
    // convert a binary string to a hexadecimal string
    $id_text = $uuid_tools->idTextToId($id)
    
To convert between dashed to undashed UUIDs, two methods are implemented:

    // convert a hexadecimal string with dashes to a hexadecimal string without dashes:
    $id_text_no_dashes = $uuid_tools->removeDashes($id_text)
    
    // convert a hexadecimal string without dashes to a hexadecimal string with dashes:
    $id_text = $uuid_tools->addDashes($id_text_no_dashes)  
    