// Fill out your copyright notice in the Description page of Project Settings.

#include "Enemy1.h"
#include "Player1.h"
#include "Components/CapsuleComponent.h"
#include "Components/SphereComponent.h"
#include "Enemy_AI_Controller.h"
#include "Kismet/GameplayStatics.h"


// Sets default values
AEnemy1::AEnemy1()
{
 	// Set this character to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = true;

	// Set size for collision capsule
	GetCapsuleComponent()->InitCapsuleSize(42.f, 96.0f);

	// Note: The skeletal mesh and anim blueprint references on the Mesh component (inherited from Character) 
	// are set in the derived blueprint asset named MyCharacter (to avoid direct content references in C++)

	/*Create Damage Sphere*/
	DeathSphere = CreateDefaultSubobject<USphereComponent>(TEXT("CollectionSphere"));
	DeathSphere->SetSphereRadius(500.f);
}

// Called when the game starts or when spawned
void AEnemy1::BeginPlay()
{
	Super::BeginPlay();
	
	AEnemy_AI_Controller* AIController = Cast<AEnemy_AI_Controller>(GetController());

	APlayer1* Character = Cast<APlayer1>(UGameplayStatics::GetPlayerCharacter(this, 0));

	if (AIController)
	{
		AIController->SetPlayerToFollow(Character);
	}
}
