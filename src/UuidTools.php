<?php
/**
 * UuidTools.php
 *
 * UuidTools class
 *
 * php 7+
 *
 * @category  None
 * @package   Floor9design\UuidTools
 * @author    Rick Morice <rick@floor9design.com>
 * @license   MIT
 * @version   0.0.0
 * @link      http://floor9design.com
 * @see       http://floor9design.com
 * @since     File available since Release 0.0.0
 *
 */

namespace Floor9design\UuidTools;

use Webpatser\Uuid\Uuid;
use Floor9design\MachineIdentifier\MachineIdentifier;

/**
 * Class UuidTools
 *
 * This helper provides the functions for all UUID manipulation to be done with.
 * Id are Generate a version 1, time-based, UUID, with a string.
 * Note: this is meant to be a mac address. This is not known typically, as PHP cannot discover them.
 *
 * In the case that we don't know this, MachineIdentifier is used which looks for a HD UUID.
 * Fortunately, the Uuid class doesn't check it really is a mac address, it simply converts the string into what
 * amounts to a salt.
 *
 * @category  None
 * @package   Floor9design\UuidTools
 * @author    Rick Morice <rick@floor9design.com>
 * @license   MIT
 * @version   0.0.0
 * @link      http://floor9design.com
 * @see       http://floor9design.com
 * @since     File available since Release 0.0.0
 */
class UuidTools
{
    /**
     * Create a new Uuid
     *
     * @param null|string $machine_id
     * @return Uuid Full uuid object
     * @throws \Exception
     */
    public function create(?string $machine_id = null): Uuid
    {
        if(!$machine_id) {
            $machine_identifier = new MachineIdentifier();
            $machine_id = $machine_identifier->uniqueMachineId();
        }

        return Uuid::generate(1, $machine_id);
    }

    /**
     * Create a new Uuid, returning just the id in bytes (for inline usage)
     *
     * @return string $uuid uuid string (in bytes)
     * @throws \Exception
     */
    public function createId() : string
    {
        $uuid = $this->create();
        return $uuid->bytes;
    }

    /**
     * Create a new Uuid, returning just the id in string form (for inline usage)
     *
     * @param bool $no_dashes Optionally the text_id without dashes
     * @return string $uuid uuid string (in text)
     * @throws \Exception
     */
    public function createIdText($no_dashes = false) : string
    {
        $uuid = $this->create();

        $text_id = $uuid->string;

        if ($no_dashes) {
            $text_id = $this->removeDashes($text_id);
        }

        return $text_id;
    }

    /**
     * @param $id
     * @return string
     */
    public function idToIdText(string $id) : string
    {
        $array = unpack("H*", $id);
        $array = preg_replace("/([0-9a-f]{8})([0-9a-f]{4})([0-9a-f]{4})([0-9a-f]{4})([0-9a-f]{12})/", "$1-$2-$3-$4-$5",
            $array);

        return $array[1];
    }

    /**
     * Converts the human readable string (with dashes) to a binary(16) (required for the primary key)
     *
     * @param $text_id
     * @return string $id
     */
    public function idTextToId($text_id) : string
    {
        return pack("H*", $this->removeDashes($text_id));
    }

    /**
     * Converts a uuid string to remove the dashes
     * eg: 42f704ab-4ae1-41c7-8c18-5558f944774 to 42f704ab4ae141c78c185558f9447748
     *
     * @param string $uuid
     * @return string $uuid
     */
    public function removeDashes(string $uuid) : string
    {
        $uuid = str_replace("-", "", $uuid);
        return $uuid;
    }

    /**
     * Converts a uuid string to add the dashes
     * eg: 42f704ab4ae141c78c185558f9447748 to 42f704ab-4ae1-41c7-8c18-5558f944774
     *
     * @param string $uuid
     * @return string $uuid
     */
    public function addDashes(string $uuid) : string
    {
        $uuid = substr($uuid, 0, 8) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4) . '-' .
            substr($uuid, 16, 4) . '-' . substr($uuid, 20);
        return $uuid;
    }
}