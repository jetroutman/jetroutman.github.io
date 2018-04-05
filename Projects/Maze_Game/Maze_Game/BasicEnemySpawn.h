// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Actor.h"
#include "BasicEnemySpawn.generated.h"

UCLASS()
class MAZE_GAME_API ABasicEnemySpawn : public AActor
{
	GENERATED_BODY()
	
public:	
	// Sets default values for this actor's properties
	ABasicEnemySpawn();

protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

public:	
	// Called every frame
	virtual void Tick(float DeltaTime) override;

	// Returns the WhereToSpawn SubObject
	FORCEINLINE class UBoxComponent* GetWhereToSpawn() const { return WhereToSpawn; }

	//Use File to get datapoints for spawning
	UFUNCTION(BlueprintPure, Category = "Spawning")
		FVector GetPickUpVolume();

protected:
	//The datapoint to spawn
	UPROPERTY(EditAnywhere, Category = "Spawning")
		TSubclassOf<class AEnemy1> WhatToSpawn;

	FTimerHandle SpawnTimer;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category = "Spawning")
		float SpawnDelayRangeLow;

	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category = "Spawning")
		float SpawnDelayRangeHigh;

private:
	//Box component to specify where data points will be spawned
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = "Spawning", meta = (AllowPrivateAccess = "true"))
		class UBoxComponent* WhereToSpawn;

	//Spawns the datapoint
	void SpawnPickUp();

	//The current spawn delay
	float SpawnDelay;
};
