SELECT
    *
FROM
    `INFORMATION_SCHEMA`.`COLUMNS`
WHERE
    `TABLE_SCHEMA` = 'api_template'
    AND `TABLE_NAME` = 'api_template_input_param';
-- same thing
SELECT
    *
FROM
    information_schema.columns
WHERE
    table_name = 'api_template_param_mapping';