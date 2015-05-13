Behat Stepler
=======================

Simple behat extension which lets you run just specific gherkin step form CLI.

## Why?

Gherkin gives us unified way to describe business requirements, but what if we want E2E tests? Let's pretend that we have project with several components: iOS application, Android application, single-page application frontend and API on backend. For all listed components there is a great tools: [cucumber.js](https://github.com/cucumber/cucumber-js), [calabash](http://calaba.sh/), [behat](http://behat.org). But if you'll start implement E2E tests you'll face a little problem: most of scenarios have some preconditions, which should be set on backend.

So... what does this extension? It just provide you a way to execute specific step anytime you want. For example, you can implement steps required by preconditions in `behat`, and then just call this steps from your `cucumber.js` suites for example.

## Usage

You can install this extension via composer:
```
$ composer require --dev fesor/behat-stepler
```

Then you'll need to add extention into your `behat.yml`:
```
default:
    suites:
        default:
            contexts:
              - FeatureContext
    extensions:
        Fesor\Stepler:
```

That's it. Now you can call just single step:

```
$ behat --run-step "Alice have user account:
| email    | alice@example.com    |
| password | alice_password       |"
```

## Contribution
Feel free to contribute! Any help or ideas will be useful!
