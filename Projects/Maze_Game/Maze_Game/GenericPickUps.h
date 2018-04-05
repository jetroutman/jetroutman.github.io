// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "PickUps.h"
#include "GenericPickUps.generated.h"

/**
 * 
 */
UCLASS()
class MAZE_GAME_API AGenericPickUps : public APickUps
{
	GENERATED_BODY()
	
public:
	// Sets default values for this actor's properties
	AGenericPickUps();

	/*Override the wascollected function - use implementation because it's a Blueprint Native Event*/
	void WasCollected_Implementation() override;

	/*Public way to access the pellet score*/
	float GetScore();

protected:
	/*Set the score the pellet gives to the character*/
	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category = "Power", Meta = (BlueprintProtected = "true"))
	float PickUpScore;	
};
