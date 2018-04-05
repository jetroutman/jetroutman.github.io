// Fill out your copyright notice in the Description page of Project Settings.

#include "BasicEnemySpawn.h"
#include "Components/BoxComponent.h"
#include "Runtime/Engine/Classes/Engine/World.h"
#include "Enemy1.h"
#include "Kismet/KismetMathLibrary.h"
#include "TimerManager.h"


// Sets default values
ABasicEnemySpawn::ABasicEnemySpawn()
{
	// Set this actor to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = true;

	//Create BoxComponent to represent the spawn volume
	WhereToSpawn = CreateDefaultSubobject<UBoxComponent>(TEXT("WhereToSpawn"));

	//Set the spawn delay range
	SpawnDelayRangeLow = 5.0f;
	SpawnDelayRangeHigh = 9.5f;

}

// Called when the game starts or when spawned
void ABasicEnemySpawn::BeginPlay()
{
	Super::BeginPlay();

	SpawnDelay = FMath::FRandRange(SpawnDelayRangeLow, SpawnDelayRangeHigh);
	GetWorldTimerManager().SetTimer(SpawnTimer, this, &ABasicEnemySpawn::SpawnPickUp, SpawnDelay, false);
}

// Called every frame
void ABasicEnemySpawn::Tick(float DeltaTime)
{
	Super::Tick(DeltaTime);

}

FVector ABasicEnemySpawn::GetPickUpVolume()
{
	FVector SpawnOrgin = WhereToSpawn->Bounds.Origin;
	
	return SpawnOrgin;
}

void ABasicEnemySpawn::SpawnPickUp()
{
	//If we have set something to spawn:
	if (WhatToSpawn != NULL)
	{
		//Check for valid world
		UWorld* const World = GetWorld();
		if (World)
		{
			//Set the Spawn parameters
			FActorSpawnParameters SpawnParams;
			SpawnParams.Owner = this;
			SpawnParams.Instigator = Instigator;

			//This is where we will pull the location for the point to spawn at
			FVector SpawnLocation = GetPickUpVolume();

			FRotator SpawnRotation(0, 0, 0);

			//Spawn the datapoint
			AEnemy1* const SpawnedDataPoint = World->SpawnActor<AEnemy1>(WhatToSpawn, SpawnLocation, SpawnRotation, SpawnParams);

			SpawnDelay = FMath::FRandRange(SpawnDelayRangeLow, SpawnDelayRangeHigh);
			GetWorldTimerManager().SetTimer(SpawnTimer, this, &ABasicEnemySpawn::SpawnPickUp, SpawnDelay, false);
		}
	}
}
