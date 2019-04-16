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

use pocketmine\item\enchantment\Enchantment;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public $enchantments = ["sharpness", "protection", "fortune", "unbreaking", "knockback"];

    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->registerEnchantments();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public function registerEnchantments() {
        Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_DIG, Enchantment::SLOT_NONE, 3));
    }
}