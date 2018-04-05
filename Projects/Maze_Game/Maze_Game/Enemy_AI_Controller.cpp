// Fill out your copyright notice in the Description page of Project Settings.

#include "Enemy_AI_Controller.h"
#include "Enemy1.h"
#include "Player1.h"
#include "BehaviorTree/BehaviorTreeComponent.h"
#include "BehaviorTree/BlackboardComponent.h"
#include "BehaviorTree/BehaviorTree.h"
#include "AIModule.h"
#include "Engine.h"

AEnemy_AI_Controller::AEnemy_AI_Controller()
{
	BehaviorComp = CreateDefaultSubobject<UBehaviorTreeComponent>(FName("BehaviorComp"));
	BlackboardComp = CreateDefaultSubobject<UBlackboardComponent>(FName("BlackboardComp"));

	TargetLocationKeyName = "TargetLocation";
	PatrolLocationKeyName = "PatrolLocation";
	CurrentWaypointKeyName = "CurrentWaypoint";
	BotTypeKeyName = "BotType";
	PlayerToFollow = "PlayerToFollow";
}

void AEnemy_AI_Controller::Possess(APawn * Pawn)
{
	Super::Possess(Pawn);

	AEnemy1* AICharacter = Cast<AEnemy1>(Pawn);

	if (AICharacter)
	{
		if (AICharacter->BehaviorTree->BlackboardAsset)
		{
			BlackboardComp->InitializeBlackboard(*(AICharacter->BehaviorTree->BlackboardAsset));
			BehaviorComp->StartTree(*AICharacter->BehaviorTree);
		}
		else {
			UE_LOG(LogTemp, Error, TEXT("AStateController is not linked the a AStateNPC."));
		}
	}

}

void AEnemy_AI_Controller::SetPlayerToFollow(APawn * Pawn)
{
	if (BlackboardComp)
	{
		BlackboardComp->SetValueAsObject(FName("PlayerToFollow"), Pawn);
	}
}

void AEnemy_AI_Controller::SetMoveToTarget(APawn* Pawn)
{
	if (BlackboardComp)
	{
		SetPlayerToFollow(Pawn);

		if (Pawn)
		{
			BlackboardComp->SetValueAsVector(TargetLocationKeyName, Pawn->GetActorLocation());
		}
	}
}
