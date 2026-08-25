<?php

/**
 * Not an exercise. Discovery is glob('harness/*.php'), top level only, so a file down here
 * is required by the exercises that need it rather than listed as one of them.
 *
 * The third of the three layers that keep an accident out of a harness:
 *
 *   1. rig itself does not load the package's .env when CLAUDECODE is set. Nothing is
 *      needed from the package for that one, which is what makes it the layer that
 *      protects a harness whose author never thought about any of this. It arrived in
 *      hampel/rig 0.2.0, so composer.json asks for ^0.2 to have it at all.
 *   2. each exercise defaults to the harmless thing, and the real effect is opt-in. In
 *      THIS harness that layer is structural rather than a default: every call goes
 *      through ReadOnlyTransport, which refuses any operation not on a verified
 *      allowlist. See the note there for why a decorator rather than care.
 *   3. this: the opt-in itself is refused under an agent.
 *
 * Nothing in this harness needs (3) yet, because nothing in it can write. It is here
 * because the moment somebody adds an exercise that can, the guard has to already exist
 * and already be named - deciding it while something depends on the answer is how the
 * decision gets made badly.
 */

/**
 * Whether the real effect must be refused: an agent is running, and has not been told
 * that this once it may.
 *
 * CLAUDECODE is a fact about who is running the command, which is the one thing a stale
 * .env cannot fake. The variable named here is the deliberate act, and belongs on the
 * command line and never in .env - a persisted one would recreate the very problem.
 *
 * Both reads fail safe. An absent or renamed CLAUDECODE falls back to the ordinary opt-in
 * - which is still the harmless default unless asked - rather than to "assume human,
 * proceed", so a rename upstream costs this layer and not the safety. And the override is
 * exactly '1': an environment variable is always a string, so a loose test would make
 * =0 mean yes.
 */
function harness_agent_refuses(string $variable): bool
{
    return getenv('CLAUDECODE') !== false && getenv($variable) !== '1';
}
