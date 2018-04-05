// Fill out your copyright notice in the Description page of Project Settings.

#include "GenericPickUps.h"

AGenericPickUps::AGenericPickUps()
{
	//base score of pellets
	PickUpScore = 10.f;
}

void AGenericPickUps::WasCollected_Implementation()
{
	/*First use the basepickup behavior*/
	Super::WasCollected_Implementation();
	/*Destroy the pellet*/
	Destroy();
}

float AGenericPickUps::GetScore()
{
	return PickUpScore;
}
