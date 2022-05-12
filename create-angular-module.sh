#!/bin/bash

MODULE_DIRECTORY=./angular-module

openapi-generator-cli generate -g typescript-angular -o $MODULE_DIRECTORY -i docs.json -c api-config.json --skip-validate-spec

find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydramember/'hydra:member'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydratotalItems/'hydra:totalItems'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydraview/'hydra:view'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydrasearch/'hydra:search'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydratemplate/'hydra:template'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydravariableRepresentation/'hydra:variableRepresentation'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydramapping/'hydra:mapping'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydrafirst/'hydra:first'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydralast/'hydra:last'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydranext/'hydra:next'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydraprevious/'hydra:previous'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "s/hydraprevious/'hydra:previous'/g" {} \;
find "$MODULE_DIRECTORY" -type f -exec sed -i -e "1N;N; s/readonly context[?]: string [|] any [|] null;\s*readonly id[?]: string;\s*\n/FOOBAR/gm" {} \;
find "$MODULE_DIRECTORY" -type f -name "*jsonld*" -exec sed -i -e "s/readonly context[?]: string [|] any [|] null;/readonly '@context?': string | any | null;/g" {} \;
find "$MODULE_DIRECTORY" -type f -name "*jsonld*" -exec sed -i -e "s/readonly type[?]: string;/readonly '@type'?: string;/g" {} \;
find "$MODULE_DIRECTORY" -type f -name "*jsonld*" -exec sed -i -e "s/readonly id[?]: string;/readonly '@id'?: string;/g" {} \;
