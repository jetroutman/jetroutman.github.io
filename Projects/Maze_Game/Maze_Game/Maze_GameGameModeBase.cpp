// Fill out your copyright notice in the Description page of Project Settings.

#include "Maze_GameGameModeBase.h"
#include "Player1.h"
#include "Kismet/GameplayStatics.h"
#include "Runtime/UMG/Public/Blueprint/UserWidget.h"
#include "Engine.h"


AMaze_GameGameModeBase::AMaze_GameGameModeBase()
{
	PrimaryActorTick.bCanEverTick = true;
}

void AMaze_GameGameModeBase::BeginPlay()
{
	Super::BeginPlay();
	SetCurrentState(EGamePlayState::EPlaying);

	//set the score to beat
	APlayer1* MyCharacter = Cast<APlayer1>(UGameplayStatics::GetPlayerPawn(this, 0));
	if (MyCharacter)
	{
		ScoreToWin = (MyCharacter->GetInitialScore())*2.25f;
	}

	if (HUDWidgetClass != nullptr)
	{
		CurrentWidget = CreateWidget<UUserWidget>(GetWorld(), HUDWidgetClass);
		if (CurrentWidget != nullptr)
		{
			CurrentWidget->AddToViewport();
		}
	}
}

void AMaze_GameGameModeBase::Tick(float DeltaTime)
{

	Super::Tick(DeltaTime);

	APlayer1* MyCharacter = Cast<APlayer1>(UGameplayStatics::GetPlayerPawn(this, 0));
	if (MyCharacter)
	{

		//*Sets the game state to won if your power lever is greater than win state*/
		if (MyCharacter->GetCurrentScore() > ScoreToWin)
		{
			SetCurrentState(EGamePlayState::EWon);
			UGameplayStatics::OpenLevel(GetWorld(), "Level_2");
		}

		///*If the character's power is positive*/
		//else if (MyCharacter->GetCurrentScore() > 0)
		//{
		//	/*Decayin power  by time*/
		//	MyCharacter->UpdateScore(-DeltaTime*DecayRate*(MyCharacter->GetInitialScore()));
		//}
		//else
		//{
		//	SetCurrentState(EGamePlayState::EGameOver);
		//}
	}
}

EGamePlayState AMaze_GameGameModeBase::GetCurrentState() const
{
	return CurrentState;
}

EGamePlayState AMaze_GameGameModeBase::GetCharacterState() const
{
	return EGamePlayState();
}

void AMaze_GameGameModeBase::SetCurrentState(EGamePlayState NewState)
{
	CurrentState = NewState;
}

void AMaze_GameGameModeBase::SetCharacterState(EGamePlayState NewState)
{
}

float AMaze_GameGameModeBase::GetScoreToWin() const
{
	return ScoreToWin;
}