// Fill out your copyright notice in the Description page of Project Settings.

#include "SpawningDataPoints.h"
#include "Components/BoxComponent.h"
#include "Runtime/Engine/Classes/Engine/World.h"
#include "Kismet/GameplayStatics.h"
#include "DataPoint.h"
#include <fstream>
#include <istream>
#include <cstdlib>
#include <iostream>

// Sets default values
ASpawningDataPoints::ASpawningDataPoints()
{
 	// Set this actor to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = true;

	//Create BoxComponent to represent the spawn volume
	WhereToSpawn = CreateDefaultSubobject<UBoxComponent>(TEXT("WhereToSpawn"));
	
}

// Called when the game starts or when spawned
void ASpawningDataPoints::BeginPlay()
{
	Super::BeginPlay();
	std::ifstream infile;
	infile.open("c:\\test\\VRData.txt");//opes up file with the data
	if (infile)
	{
		int nodes, dimensions;
		infile >> nodes >> dimensions;
		//Grabs data from file and store it into the array of nodes
		for (int i = 0; i < nodes; i++)
		{
			datarow.Add(datalist());//adds new row of data
			for (int j = 0; j < dimensions; j++)
			{
				float val;
				infile >> val;
				datarow[i].newdata.Add(val);//adds new point in the row of data
			}
		}
		//stores initial values for max min for x, y, and z
		minx = datarow[0].newdata[0];
		miny = datarow[0].newdata[1];
		minz = datarow[0].newdata[2];
		maxx = datarow[0].newdata[0];
		maxy = datarow[0].newdata[1];
		maxz = datarow[0].newdata[2];
		//finds min max for each dimension
		for (int i = 0; i<nodes; i++)
		{
			if (minx > datarow[i].newdata[0])
				minx = datarow[i].newdata[0];
			if (miny > datarow[i].newdata[1])
				miny = datarow[i].newdata[1];
			if (minz > datarow[i].newdata[2])
				minz = datarow[i].newdata[2];
			if (maxx < datarow[i].newdata[0])
				maxx = datarow[i].newdata[0];
			if (maxy < datarow[i].newdata[1])
				maxy = datarow[i].newdata[1];
			if (maxz < datarow[i].newdata[2])
				maxz = datarow[i].newdata[2];
		}
		//Finds the total distance for each data point
		Xd = maxx - minx;
		Yd = maxy - miny;
		Zd = maxz - minz;
		//finds the orgin or mid point of the data for this dimension
		originX = (maxx + minx) / 2;
		originY = (maxy + miny) / 2;
		originZ = (maxz + minz) / 2;
		//Send data to spawn function
		for (int i = 0; i < nodes; i++)
		{
			SpawnDatapoint(datarow[i]);
		}
	}else UE_LOG(LogTemp, Error, TEXT("Unable to open data file"));
	
	
}

// Called every frame
void ASpawningDataPoints::Tick(float DeltaTime)
{
	Super::Tick(DeltaTime);

}

FVector ASpawningDataPoints::GetDataPointVolume(float xval, float yval, float zval)
{
	//Where to Spawn need to pull from file
	FVector SpawnOrgin = WhereToSpawn->Bounds.Origin;
	FVector SpawnExtent = WhereToSpawn->Bounds.BoxExtent;
	float spawnx, spawny, spawnz;
	spawnx = (xval - originX) * (((SpawnExtent.X * 2) - 25) / Xd);
	spawny = (yval - originY) * (((SpawnExtent.Y * 2) - 25) / Yd);
	spawnz = (zval - originZ) * (((SpawnExtent.Z * 2) - 25) / Zd);
	return FVector(spawnx, spawny, spawnz);
}

void ASpawningDataPoints::SpawnDatapoint(struct datalist data)
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
			FVector SpawnLocation = GetDataPointVolume(data.newdata[0], data.newdata[1], data.newdata[2]);

			FRotator SpawnRotation(0, 0, 0);
			FTransform Spawntrans(SpawnLocation);
			FVector removetranslation(0, 0, 0);

			//Spawn the datapoint
			//ADataPoint* const SpawnedDataPoint = World->SpawnActor<ADataPoint>(WhatToSpawn, SpawnLocation, SpawnRotation, SpawnParams);
			ADataPoint* const SpawnedDataPoint = World->SpawnActorDeferred<ADataPoint>(WhatToSpawn, Spawntrans, SpawnParams.Owner, SpawnParams.Instigator);
			if (SpawnedDataPoint)
			{
				SpawnedDataPoint->GetData(data.newdata);
				UGameplayStatics::FinishSpawningActor(SpawnedDataPoint, Spawntrans);
			}
		}
	}
}

