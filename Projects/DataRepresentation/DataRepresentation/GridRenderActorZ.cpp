// Fill out your copyright notice in the Description page of Project Settings.

#include "GridRenderActorZ.h"
#include "SpawningDataPoints.h"
#include "UnrealString.h"
#include "Components/TextRenderComponent.h"
#include "Engine.h"

AGridRenderActorZ::AGridRenderActorZ()
{
	FString unrealName = "0";
	displayText = CreateDefaultSubobject<UTextRenderComponent>(*unrealName);

	size = 5.0f;//scale of the size of the numbers
}

void AGridRenderActorZ::BeginPlay()
{
	Super::BeginPlay();

	FVector location = AActor::GetActorLocation();
	FString LocationString = FString::SanitizeFloat(location.Z);

	// create text render component with some default values

	displayText->SetText(LocationString);
	displayText->SetTextRenderColor(FColor::Blue);
	displayText->SetXScale(size);
	displayText->SetYScale(size);
	displayText->SetHorizontalAlignment(EHorizTextAligment::EHTA_Center);

	GEngine->AddOnScreenDebugMessage(-1, 5.f, FColor::Blue, LocationString);
}