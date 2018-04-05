// Fill out your copyright notice in the Description page of Project Settings.

#include "DataPoint.h"
#include "Components/StaticMeshComponent.h"


// Sets default values
ADataPoint::ADataPoint()
{
 	// Set this actor to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = false;

	//Create the static mesh component
	DatapointMesh = CreateDefaultSubobject<UStaticMeshComponent>(TEXT("DatapointMesh"));
	RootComponent = DatapointMesh;
	
}

void ADataPoint::GetData(TArray<float> datapts)
{
	//Iterates through each datapoint and adds it to the datapoint in this actor
	for (int i = 0; i < datapts.Num(); i++)
	{
		data.Add(datapts[i]);
	}
}

// Called when the game starts or when spawned
void ADataPoint::BeginPlay()
{
	Super::BeginPlay();
	
}

// Called every frame
void ADataPoint::Tick(float DeltaTime)
{
	Super::Tick(DeltaTime);

}

