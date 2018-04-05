// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Character.h"
#include "Enemy1.generated.h"

UCLASS()
class MAZE_GAME_API AEnemy1 : public ACharacter
{
	GENERATED_BODY()

	/*Collection Sphere*/
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = "Camera", meta = (AllowPrivateAccess = "true"))
	class USphereComponent* DeathSphere;

public:
	// Sets default values for this character's properties
	AEnemy1();

	UPROPERTY(EditAnywhere, Category = "Behavior")
	class UBehaviorTree* BehaviorTree;



protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

	/*Return Death Sphere Subobject*/
	FORCEINLINE class USphereComponent* GetCollectionSphere() const { return DeathSphere; }
	
};
