<?php
// class-construct
class pokemon
{
	public $name;
	public $energyType;
	public $hitpoints;
	public $health;
	public $attacks;
	public $weakness;
	public $resistance;

	public function __construct($name, $energyType, $hitpoints, $attacks, $weakness, $resistance)
	{
		$this->name = $name;
		$this->energyType = $energyType;
		$this->hitpoints = $hitpoints;
        $this->health = $this->hitpoints;
		$this->attacks = $attacks;
		$this->weakness = $weakness;
		$this->resistance = $resistance;

		$this->increasePopulation();
	}

	public function attacks($target, $attack){
		if($this->health <= 0){ 
			print $this->name . " does not have anymore health so it can no longer attack!<br><br>";
		} else {
			$damage = $this->attacks[$attack]->damage;

			echo $this->name . " attacks " . $target->name . " with " . $this->attacks[$attack]->name . " ";

			// Two simple checks for weakness and resistance (It simply compares the names, if the same then add multiplier)
			if ($this->energyType->name == $target->weakness->energyType->name) {
				$damage = $damage * $target->weakness->multiplier;
			}
			if ($this->energyType->name == $target->resistance->energyType->name) {
				$damage -= $target->resistance->value;
			}
			$target->hitpoints -= $damage;

			echo "dealing a total of " . $damage . " damage.<br> " . $target->name . " is left with " . $target->hitpoints . " hitpoints <br><br>";
			$target->health = $target->hitpoints;

			// check if the pokemon is dead, then run decreasePopulation
			if($target->health == 0 || $target->health < 0){
				print $target->name . " Lost all of their health and died <br><br>";
				$target->decreasePopulation($target);
			}
		}
    }

	// Functions to increase and decrease the total population
	public function increasePopulation(){
		global $livingPokemon;

		array_push($livingPokemon, $this);
	}
	public function decreasePopulation($target){
		global $livingPokemon;
		
		for($a=0; $a<=count($livingPokemon)-1; $a++){
			if($livingPokemon[$a]->name == $target->name){
				unset($livingPokemon[$a]);
			}
		}
	}
}

function getPopulation(){
		global $livingPokemon;

		print "The total number of living pokemon: " . count($livingPokemon) . "<br><br>";
}
?>