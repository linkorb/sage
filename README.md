Sage
====

A Sage instance allows you to

1. Transparently access data stored in Repositories of different types (PDO, Array, Cache, NdJson files, etc) as in-memory arrays
2. Traverse relations (one-to-many, many-to-one) between them
3. Access virtual fields (akin to GraphQL field resolvers) for modifications, calculations and other advanced use-cases

Sage can be thought of as a supersedence of [linkorb/context](https://github.com/linkorb/context).

## Usage

1. Instantiate a new Sage\Sage instance
2. Instantiate a Repository for each table/collection you'd like to access
3. Attach the Repositories to the Sage instance
4. Add "Virtual Fields" to specify relations between tables or add data modifiers
5. Query tables using common `findAll()` with conditions
6. Access the resulting rows as an array, allowing you to traverse the array as if it is all in-memory (Sage lazy-loads accessed rows behind the scenes).

## Definitions

* **Sage**: A collection of repositories and virtual fields

* **Repository**: Analogue to a database table/collection. May be backed by different storage methods (see src/Repository/ for current implementations)

* **Record**: An in-memory Record can be accessed as an array (`$user['name']`) and supports many-to-one and one-to-many relations to other tables though virtual fields

## Use-cases

* Rapid application development: You don't need to model objects (with getters/setters/etc) in order to work with them. Just load raw data (from json, yaml, arrays, pdo, etc for example) and you're ready to traverse the repositories and records within it.
* Complex medical record mapping/conversion: Use a "context" (subset of records pertaining to a single medical record or patient) then easily traverse it through it's relations.
* Structured Documentation: Model information according to it's domain, then load it into a Context and use (twig/mustache/handlebars) templates to traverse the information.
* GraphQL datastore: A Sage instance is in essence a Graph. A context can therefor be used to generate a GraphQL server which can be used by other applications to easily query the context in a format of their choosing.
* Natural user interface/email/view generation: Simply define a context into a view, and loop over it with any template language such as twig, handlebars, mustache, etc. No further controller logic required.

## License

MIT (see [LICENSE.md](LICENSE.md))

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
