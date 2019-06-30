# The Challenge

Imagine we have a list of jobs, each represented by a character. Because certain jobs must be done before others, a job may have a
dependency on another job. For example, a may depend on b, meaning the final sequence of jobs should place b before a. If a has no
dependency, the position of a in the final sequence does not matter.

- Given you’re passed an empty string (no jobs), the result should be an empty sequence.

* Given the following job structure:

```
a =>
```

The result should be a sequence consisting of a single job a.

- Given the following job structure:

```
a =>
b =>
c =>
```

The result should be a sequence containing all three jobs abc in no significant order.

- Given the following job structure:

```
a =>
b => c
c =>
```

The result should be a sequence that positions c before b, containing all three jobs abc.

- Given the following job structure:

```
a =>
b => c
c => f
d => a
e => b
f =>
```

The result should be a sequence that positions f before c, c before b, b before e and a before d containing all six jobs abcdef.

- Given the following job structure:

```
a =>
b =>
c => c
```

The result should be an error stating that jobs can’t depend on themselves.

- Given the following job structure:

```
a =>
b => c
c => f
d => a
e =>
f => b
```

The result should be an error stating that jobs can’t have circular dependencies.

# My solution

## Main idea

To solve this problem i started to run the example that was given and search for a global idea.

The first idea that i had is that there's two cases where we can run a job

- If the job has no dependency
- If the jobs dependency has been already ran

After that, i see that the job that have dependencies must be stored in a manner that the job comes after the dependency. And there's not a better structure than a stack that can ensure that kind of job (Last job in, first job out ).

In the same way, we can use a queue to save the job as the first job in will be the first job out.

## Structure

So to sum up here's the structure that we will use to implement the solution

### Queue

The queue will have the final state ie. how the jobs will be executed

### Stack

Stack will save the job and their dependencies, so the job at the top of the stack is the first who will be added to the queue and latest job is the latest job insterted in the queue.

### Array

We will use an array to save the structure as following :

- The index of the array is the job and the value represent the dependency.
- If a job doesn't have a dependency the value is set to null.

## Implementation

The most important part of the problem is how we fill the stack and the queue, so here's the specific cases that we have to deal with :

- Structure is empty : Print an empty sequence and skip the rest

- Structure has no dependency : Return a sequence in a no significant order

* Job has no dependency : Add to the queue

- Job has dependency :
  -- Dependency exist in the queue : Add job to the queue.
  -- Job and dependency doesn't exist in the stack : Add job to the stack and after that add dependency to the stack.
  -- Job doesn't exist in the stack but dependency exist in the stack : Add job before the dependency in the stack.
  -- Job exist in the stack and dependency doesn't : Add dependency to the stack
  -- Job and dependency doesn't exist in the stack : Add job to the stack and after that add dependency to the stack.

Once we have the stack and queue filled, we have to fill the queue with stack value.

## Unit testing

To run the test coverage, i used PHPunit and write a JobScheduling class test when i test all the challenge described in "The challenge" section. The challenges are numbered from 0 to 6

## Installation

To install the project just run on the current directory of the project:

```
composer install
```

To run test, just execute :

```
./vendor/bin/phpunit
```
