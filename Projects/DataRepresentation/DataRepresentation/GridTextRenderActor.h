// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "Engine/TextRenderActor.h"
#include "GridTextRenderActor.generated.h"

/**
 * 
 */
UCLASS()
class DATAREPRESENTATION_API AGridTextRenderActor : public ATextRenderActor
{
	GENERATED_BODY()
	
public:
	// Sets default values for this actor's properties
	AGridTextRenderActor();

	UPROPERTY(EditAnywhere, Category = "Grid")
	float size;

	UPROPERTY(VisibleInstanceOnly, Category = "Grid")
	UTextRenderComponent* displayText;

protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;
};
