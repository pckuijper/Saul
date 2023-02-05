# Saul
A bare-bones music library thing that showcases Hexagonal architecture

To configure and run  it, please follow these steps:
- You need to set up a spotify api key + secret in a `.env.dev.local` file.
  See `.env` for the required keys
- Run the `bin/setup` command, If needed, you might have to update the database url inside your env config file (`.env.dev.local`)
- Run the command to fetch the latest data: `bin/console saul:album:find-latest`
  Or have a look at bin/console to find all commands associated with the project, they will be prefixed with `saul:`

## Tests
### Unit tests
Run test by using `bin/phpunit`.
This does require the database to be created and migrated. (running `bin/setup` should be enough).

### Phpstan
Run phpstan by using `bin/phpstan`
Run the code through max level phpstan to check for problems using static analysis.

### Code style
Run cs fixer by using `bin/test-cs`, these can be fixed using `bin/fix-cs`.

## Next steps

- Use a message queue (symfony messenger) to offload logic to workers
- Fetch more artist information from spotify
- Fetch related artists and their albums
- Create CLI viewer of artist data
