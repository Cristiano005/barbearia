<?php

use app\classes\validation\PersistedData;

function persistedData(string $field) {
    return PersistedData::get($field);
}
