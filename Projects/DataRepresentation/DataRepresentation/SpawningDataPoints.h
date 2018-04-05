// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Actor.h"
#include "SpawningDataPoints.generated.h"

UCLASS()
class DATAREPRESENTATION_API ASpawningDataPoints : public AActor
{
	GENERATED_BODY()
	
	struct datalist
	{
		UPROPERTY()
		TArray<float> newdata;
		
		void AddPoint(float point) {
			newdata.Add(point);
		}
	};
public:	
	// Sets default values for this actor's properties
	ASpawningDataPoints();

	TArray<datalist> datarow;
	//stores maxes and mins for each dimension
	float minx, miny, minz, maxx, maxy, maxz;
	//stores distance and midpoint for each dimension
	float Xd, Yd, Zd, originX, originY, originZ;

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
	FVector GetDataPointVolume(float xval, float yval, float zval);

	int nodes = 0;
	int dimensions = 0;

protected:
	//The datapoint to spawn
	UPROPERTY(EditAnywhere, Category = "Spawning")
	TSubclassOf<class ADataPoint> WhatToSpawn;

private:
	//Box component to specify where data points will be spawned
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = "Spawning", meta = (AllowPrivateAccess = "true"))
	class UBoxComponent* WhereToSpawn;

	//Spawns the datapoint
	void SpawnDatapoint(struct datalist data);
};
