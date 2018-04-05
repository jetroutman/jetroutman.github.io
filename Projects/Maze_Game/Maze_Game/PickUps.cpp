// Fill out your copyright notice in the Description page of Project Settings.

#include "PickUps.h"
#include "Components/StaticMeshComponent.h"


// Sets default values
APickUps::APickUps()
{
 	// Set this actor to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = true;

	//All pickups start as active
	bIsActive = true;

	//Create static mesh component
	Mesh = CreateDefaultSubobject<UStaticMeshComponent>(TEXT("PickupMesh"));
	RootComponent = Mesh;
}

// Called when the game starts or when spawned
void APickUps::BeginPlay()
{
	Super::BeginPlay();
}

// Called every frame
void APickUps::Tick(float DeltaTime)
{
	Super::Tick(DeltaTime);
	
	FVector NewLocation = GetActorLocation();
	float DeltaHeight = (FMath::Sin(RunningTime + DeltaTime) - FMath::Sin(RunningTime));
	NewLocation.Z += DeltaHeight * 25.0f;       //Scale our height by a factor of 50
	RunningTime += DeltaTime;
	SetActorLocation(NewLocation);
}

bool APickUps::IsActive()
{
	return bIsActive;
}

void APickUps::SetActive(bool NewPickupState)
{
	bIsActive = NewPickupState;
}

void APickUps::WasCollected_Implementation()
{
	/*Log a debug message*/
	FString PickupDebugString = GetName();
	UE_LOG(LogClass, Log, TEXT("You have collected %s"), *PickupDebugString);
}

