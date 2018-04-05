// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/GameModeBase.h"
#include "Maze_GameGameModeBase.generated.h"

/**
*enum to store the current state of gameplay
*/
UENUM(BlueprintType)
enum class EGamePlayState : uint8
{
	EPlaying UMETA(DisplayName = "Playing"),
	EGameOver UMETA(Displayname = "Game Over"),
	EWon UMETA(DisplayName = "Won"),
	EUnknown UMETA(DisplayName = "Unknown")
};

UENUM(BlueprintType)
enum class ECharacterRelationState : uint8
{
	ENormal UMETA(DisplayName = "Normal"),
	EBronze UMETA(Displayname = "Bronze"),
	EGold UMETA(DisplayName = "Gold"),
	EUnknown UMETA(DisplayName = "Unknown")
};

UCLASS()
class MAZE_GAME_API AMaze_GameGameModeBase : public AGameModeBase
{
	GENERATED_BODY()
		
public:
	AMaze_GameGameModeBase();

	//Returns power needed to win - needed for the HUD
	UFUNCTION(BlueprintPure, Category = "Score")
	float GetScoreToWin() const;

	// Called every frame
	virtual void Tick(float DeltaTime) override;

	//*Returns the current playing state*/
	UFUNCTION(BlueprintPure, Category = "Score")
	EGamePlayState GetCurrentState() const;

	//*Returns the current Character State for material*/
	UFUNCTION(BlueprintPure, Category = "CharacterInfo")
	EGamePlayState GetCharacterState() const;

	/*Sets a new playing state*/
	void SetCurrentState(EGamePlayState NewState);

	/*Sets a new character state*/
	void SetCharacterState(EGamePlayState NewState);
	
protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

	//Rate at which the character loses power
	UPROPERTY(EditDefaultsOnly, BlueprintReadWrite, Category = "Score", Meta = (BlueprintProtected = "true"))
	float DecayRate;

	//Power needed to win the Game
	UPROPERTY(EditDefaultsOnly, BlueprintReadWrite, Category = "Score", Meta = (BlueprintProtected = "true"))
	float ScoreToWin;

	/*The Widget class to use for the HUD screen*/
	UPROPERTY(EditDefaultsOnly, BlueprintReadWrite, Category = "Score", Meta = (BlueprintProtected = "true"))
	TSubclassOf<class UUserWidget> HUDWidgetClass;

	/* the instance of the HUD*/
	class UUserWidget* CurrentWidget;

private:
	/*Keep track of the current playing state*/
	EGamePlayState CurrentState;

	//TArray<class ASpawningVolume*>SpawnVolumeActors;
};