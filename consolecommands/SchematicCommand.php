<?php

namespace Craft;

class SchematicCommand extends BaseCommand
{
    /**
     * Imports the Craft datamodel.
     *
     * @param string $file  json file containing the schema definition
     * @param bool   $force if set to true items not in the import will be deleted
     */
    public function actionImport($file = 'craft/config/schema.json', $force = false)
    {
        if (!IOHelper::fileExists($file)) {
            $this->usageError(Craft::t('File not found.'));
        }

        $json = IOHelper::getFileContents($file);

        $result = craft()->schematic->importFromJson($json, $force);

        if ($result->ok) {
            echo Craft::t('Loaded schema from {file}', array('file' => $file))."\n";
        }

        echo Craft::t('There was an error loading schema from {file}', array('file' => $file))."\n";
        print_r($result->errors);
    }

    /**
     * Exports the Craft datamodel.
     *
     * @param string $file file to write the schema to
     */
    public function actionExport($file = 'craft/config/schema.json')
    {
        $schema = craft()->schematic->export();

        IOHelper::writeToFile($file, json_encode($schema, JSON_PRETTY_PRINT));
    }
}