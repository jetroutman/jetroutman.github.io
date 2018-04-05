// Fill out your copyright notice in the Description page of Project Settings.

#include "GridTextRenderActor.h"
#include "SpawningDataPoints.h"
#include "UnrealString.h"
#include "Components/TextRenderComponent.h"
#include "Engine.h"


AGridTextRenderActor::AGridTextRenderActor()
{
	FString unrealName = "0";
	displayText = CreateDefaultSubobject<UTextRenderComponent>(*unrealName);

	size = 5.0f;//scale of the size of the numbers
}

void AGridTextRenderActor::BeginPlay()
{
	Super::BeginPlay();

	FVector location = AActor::GetActorLocation();
	FString LocationString = FString::SanitizeFloat(location.X);

	// create text render component with some default values
	
	displayText->SetText(LocationString);
	displayText->SetTextRenderColor(FColor::Red);
	displayText->SetXScale(size);
	displayText->SetYScale(size);
	displayText->SetHorizontalAlignment(EHorizTextAligment::EHTA_Center);

	GEngine->AddOnScreenDebugMessage(-1, 5.f, FColor::Red, LocationString);
}
