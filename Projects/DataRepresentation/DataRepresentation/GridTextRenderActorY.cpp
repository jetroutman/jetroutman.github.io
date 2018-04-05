// Fill out your copyright notice in the Description page of Project Settings.

#include "GridTextRenderActorY.h"
#include "SpawningDataPoints.h"
#include "UnrealString.h"
#include "Components/TextRenderComponent.h"
#include "Engine.h"

AGridTextRenderActorY::AGridTextRenderActorY()
{
	FString unrealName = "0";
	displayText = CreateDefaultSubobject<UTextRenderComponent>(*unrealName);

	size = 5.0f;//scale of the size of the numbers
}

void AGridTextRenderActorY::BeginPlay()
{
	Super::BeginPlay();

	FVector location = AActor::GetActorLocation();
	FString LocationString = FString::SanitizeFloat(location.Y);

	// create text render component with some default values

	displayText->SetText(LocationString);
	displayText->SetTextRenderColor(FColor::Green);
	displayText->SetXScale(size);
	displayText->SetYScale(size);
	displayText->SetHorizontalAlignment(EHorizTextAligment::EHTA_Center);

	GEngine->AddOnScreenDebugMessage(-1, 5.f, FColor::Green, LocationString);
}