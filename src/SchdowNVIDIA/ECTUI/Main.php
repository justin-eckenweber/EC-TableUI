<?php

/*
    EC-TableUI:

    Copyright (C) 2019 SchdowNVIDIA
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

declare(strict_types = 1);

namespace SchdowNVIDIA\ECTUI;

use pocketmine\block\Block;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public $swordEnchantments = [];
    public $armorEnchantments = [];
    public $toolEnchantments = [];
    public $bowEnchantments = [];

    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->initEnchantments();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public function initEnchantments() {
        // registering some missing enchantments
        Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_DIG, Enchantment::SLOT_NONE, 3));
        Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE, 3));

        $this->swordEnchantments = $this->getConfig()->get("swordEnchantments");
        $this->armorEnchantments = $this->getConfig()->get("armorEnchantments");
        $this->toolEnchantments = $this->getConfig()->get("toolEnchantments");
        $this->bowEnchantments = $this->getConfig()->get("toolEnchantments");
    }

    public function getBookshelfs(Block $ectable) : int {
        $count = 0;
        $level = $ectable->getLevel();
        // b stands for "base"
        $bx = $ectable->getX();
        $by = $ectable->getY();
        $bz = $ectable->getZ();
        // Right
        for($i = 0; $i <= 2; $i++) {
            for($ii = 0; $ii <= 2; $ii++) {
                if ($i === 0) {
                    if ($level->getBlockIdAt($bx, $by + $ii, $bz + 2) === Block::BOOKSHELF) {
                        $count++;
                    }
                } else {
                    if ($level->getBlockIdAt($bx + $i, $by + $ii, $bz + 2) === Block::BOOKSHELF) {
                        $count++;
                    }
                    if ($level->getBlockIdAt($bx - $i, $by + $ii, $bz + 2) === Block::BOOKSHELF) {
                        $count++;
                    }
                }
            }
        }
        // Left
        for($i = 0; $i <= 2; $i++) {
            for($ii = 0; $ii <= 2; $ii++) {
                if ($i === 0) {
                    if ($level->getBlockIdAt($bx, $by + $ii, $bz - 2) === Block::BOOKSHELF) {
                        $count++;
                    }
                } else {
                    if ($level->getBlockIdAt($bx + $i, $by + $ii, $bz - 2) === Block::BOOKSHELF) {
                        $count++;
                    }
                    if ($level->getBlockIdAt($bx - $i, $by + $ii, $bz - 2) === Block::BOOKSHELF) {
                        $count++;
                    }
                }
            }
        }
        // Top
        for($i = 0; $i <= 1; $i++) {
            for($ii = 0; $ii <= 2; $ii++) {
                if ($i === 0) {
                    if ($level->getBlockIdAt($bx + 2, $by + $ii, $bz) === Block::BOOKSHELF) {
                        $count++;
                    }
                } else {
                    if ($level->getBlockIdAt($bx + 2, $by + $ii, $bz + $i) === Block::BOOKSHELF) {
                        $count++;
                    }
                    if ($level->getBlockIdAt($bx + 2, $by + $ii, $bz - $i) === Block::BOOKSHELF) {
                        $count++;
                    }
                }
            }
        }
        // Bottom
        for($i = 0; $i <= 1; $i++) {
            for($ii = 0; $ii <= 2; $ii++) {
                if ($i === 0) {
                    if ($level->getBlockIdAt($bx - 2, $by + $ii, $bz) === Block::BOOKSHELF) {
                        $count++;
                    }
                } else {
                    if ($level->getBlockIdAt($bx - 2, $by + $ii, $bz + $i) === Block::BOOKSHELF) {
                        $count++;
                    }
                    if ($level->getBlockIdAt($bx - 2, $by + $ii, $bz - $i) === Block::BOOKSHELF) {
                        $count++;
                    }
                }
            }
        }
        return $count;

    }
}