// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "AIController.h"
#include "BehaviorTree/BehaviorTreeComponent.h"
#include "Enemy_AI_Controller.generated.h"

/**
 * 
 */
UCLASS()
class MAZE_GAME_API AEnemy_AI_Controller : public AAIController
{
	GENERATED_BODY()

public:
	//defualt constructer
	AEnemy_AI_Controller();

	virtual void Possess(APawn* Pawn) override;
	
	void SetPlayerToFollow(APawn* Pawn);

	void SetMoveToTarget(APawn * Pawn);
	
protected:
	UBlackboardComponent* BlackboardComp;
	UBehaviorTreeComponent* BehaviorComp;

	UPROPERTY(EditDefaultsOnly, Category = "AI")
	FName PlayerToFollow;

	UPROPERTY(EditDefaultsOnly, Category = "AI")
	FName TargetLocationKeyName;

	UPROPERTY(EditDefaultsOnly, Category = "AI")
	FName PatrolLocationKeyName;

	UPROPERTY(EditDefaultsOnly, Category = "AI")
	FName CurrentWaypointKeyName;

	UPROPERTY(EditDefaultsOnly, Category = "AI")
	FName BotTypeKeyName;
};
