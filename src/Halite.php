<?php
namespace Halite;

class Halite {
// default constants
    const MAX_SPEED = 7;
    const SHIP_RADIUS = 0.5;
    const MAX_SHIP_HEALTH = 255;
    const BASE_SHIP_HEALTH = 255;
    const WEAPON_COOLDOWN = 1;
    const WEAPON_RADIUS = 5;
    const WEAPON_DAMAGE = 64;
    const EXPLOSION_RADIUS = 10;
    const DOCK_RADIUS = 4;
    const DOCK_TURNS = 5;
    const BASE_PRODUCTIVITY = 6;
    const SPAWN_RADIUS = 2;

// docking stats
    const UNDOCKED = 0;
    const DOCKING = 1;
    const DOCKED = 2;
    const UNDOCKING = 3;
}