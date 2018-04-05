// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Actor.h"
#include "PickUps.generated.h"

UCLASS()
class MAZE_GAME_API APickUps : public AActor
{
	GENERATED_BODY()
	
public:	
	// Sets default values for this actor's properties
	APickUps();
	FVector StartLocation;
	float RunningTime;

protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

public:	
	// Called every frame
	virtual void Tick(float DeltaTime) override;

	//Return the mesh for the datapoint
	FORCEINLINE class UStaticMeshComponent* GetMesh() const { return Mesh; }

	/*Return whether or not the pellet is active*/
	UFUNCTION(BlueprintPure, Category = "PickUp")
	bool IsActive();

	/*Allows other classes to safely change whether the pellet is active*/
	UFUNCTION(BlueprintCallable, Category = "Pellet")
	void SetActive(bool NewPickupState);

	/*Function to call when the pellet is collected*/
	UFUNCTION(BlueprintNativeEvent, Category = "Pellet")
	void WasCollected();
	virtual void WasCollected_Implementation();

private:
	//Static Mesh for the datapoint in the level
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = "Datapoint", meta = (AllowPrivateAccess = "true"))
	class UStaticMeshComponent* Mesh;

protected:
	//True when the pellet can be pellet up, false when it can not
	bool bIsActive;
};
