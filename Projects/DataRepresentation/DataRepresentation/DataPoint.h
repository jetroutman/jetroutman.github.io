// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Actor.h"
#include "DataPoint.generated.h"

UCLASS()
class DATAREPRESENTATION_API ADataPoint : public AActor
{
	GENERATED_BODY()

public:	
	// Sets default values for this actor's properties
	ADataPoint();

	void GetData(TArray<float> datapts);

protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

public:	
	// Called every frame
	virtual void Tick(float DeltaTime) override;

	//Return the mesh for the datapoint
	FORCEINLINE class UStaticMeshComponent* GetMesh() const { return DatapointMesh; }

	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = "Data", meta = (AllowPrivateAccess = "true"))
	TArray<float> data;

private:
	//Static Mesh for the datapoint in the level
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = "Datapoint", meta = (AllowPrivateAccess = "true"))
	class UStaticMeshComponent* DatapointMesh;

	
};
