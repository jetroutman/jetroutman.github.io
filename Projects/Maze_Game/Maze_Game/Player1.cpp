// Fill out your copyright notice in the Description page of Project Settings.

#include "Player1.h"
#include "Components/CapsuleComponent.h"
#include "Components/SphereComponent.h"
#include "Engine.h"
#include "PickUps.h"
#include "GenericPickUps.h"


// Sets default values
APlayer1::APlayer1()
{
 	// Set this character to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = true;

	// Set size for collision capsule
	GetCapsuleComponent()->InitCapsuleSize(42.f, 96.0f);

	// Note: The skeletal mesh and anim blueprint references on the Mesh component (inherited from Character) 
	// are set in the derived blueprint asset named MyCharacter (to avoid direct content references in C++)

	/*Create CollectionSphere*/
	CollectionSphere = CreateDefaultSubobject<USphereComponent>(TEXT("CollectionSphere"));
	CollectionSphere->SetSphereRadius(250.f);

	/*Set base score*/
	InitialScore = 200.f;
	CharacterScore = InitialScore;

	/*Set the dependence of the speed on the power level*/
	SpeedFactor = .75f;
	BaseSpeed = 2000.0f;

}

// Called when the game starts or when spawned
void APlayer1::BeginPlay()
{
	Super::BeginPlay();
	if (GEngine)
	{
		// Put up a debug message for five seconds. The -1 "Key" value (first argument) indicates that we will never need to update or refresh this message.
		GEngine->AddOnScreenDebugMessage(-1, 5.0f, FColor::Red, TEXT("We are using FPSCharacter."));
	}
}

void APlayer1::MoveForward(float Value)
{
	// Find out which way is "forward" and record that the player wants to move that way.
	FVector Direction = FRotationMatrix(Controller->GetControlRotation()).GetScaledAxis(EAxis::X);
	AddMovementInput(Direction, Value);
	CollectPickUps();
}

void APlayer1::MoveRight(float Value)
{
	// Find out which way is "forward" and record that the player wants to move that way.
	FVector Direction = FRotationMatrix(Controller->GetControlRotation()).GetScaledAxis(EAxis::Y);
	AddMovementInput(Direction, Value);

	CollectPickUps();
}

void APlayer1::TurnAtRate(float Rate)
{
}

void APlayer1::LookUpAtRate(float Rate)
{
}

// Called every frame
void APlayer1::Tick(float DeltaTime)
{
	Super::Tick(DeltaTime);


}

// Called to bind functionality to input
void APlayer1::SetupPlayerInputComponent(UInputComponent* PlayerInputComponent)
{
	Super::SetupPlayerInputComponent(PlayerInputComponent);

	PlayerInputComponent->BindAxis("MoveForward", this, &APlayer1::MoveForward);
	PlayerInputComponent->BindAxis("MoveRight", this, &APlayer1::MoveRight);
}

float APlayer1::GetInitialScore()
{
	return InitialScore;
}

float APlayer1::GetCurrentScore()
{
	return CharacterScore;
}

void APlayer1::UpdateScore(float ScoreChange)
{
	CharacterScore += ScoreChange;
	
	//Add to Change speed based on score
	//GetCharacterMovement()->MaxWalkSpeed = BaseSpeed + SpeedFactor * CharacterScore;
	
	//call visual effect
	ScoreChangeEffect();
}

void APlayer1::CollectPickUps()
{
	/*Get All overlapping Actors and store them in an Array*/
	TArray<AActor*>CollectedActors;
	CollectionSphere->GetOverlappingActors(CollectedActors);

	/*Keeps track of the collected score*/
	float CollectedScore = 0;

	/*For Each Actor we collected*/
	for (int32 iCollected = 0; iCollected < CollectedActors.Num(); ++iCollected)
	{
		/*Cast the Actor to APickUps*/
		APickUps* const TestPickup = Cast<APickUps>(CollectedActors[iCollected]);
		/*If the cast is successful and the pickup is valid and active*/
		if (TestPickup && !TestPickup->IsPendingKill() && TestPickup->IsActive())
		{
			/*Call the pickup's was collected function*/
			TestPickup->WasCollected();

			/*Check to see if the pickup is a pickups*/
			AGenericPickUps* const TestPickUp = Cast<AGenericPickUps>(TestPickup);
			if (TestPickUp)
			{
				//Increase the collected Score
				CollectedScore += TestPickUp->GetScore();
			}
			/*Deactivate the pickup*/
			TestPickup->SetActive(false);
		}
	}
	if (CollectedScore > 0)
	{
		UpdateScore(CollectedScore);
	}
}
