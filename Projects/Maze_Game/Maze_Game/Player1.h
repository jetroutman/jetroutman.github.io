// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Character.h"
#include "Player1.generated.h"

UCLASS()
class MAZE_GAME_API APlayer1 : public ACharacter
{
	GENERATED_BODY()

	/*Collection Sphere*/
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = Camera, meta = (AllowPrivateAccess = "true"))
	class USphereComponent* CollectionSphere;

public:
	// Sets default values for this character's properties
	APlayer1();

	/** Base turn rate, in deg/sec. Other scaling may affect final turn rate. */
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = Camera)
		float BaseTurnRate;

	/** Base look up/down rate, in deg/sec. Other scaling may affect final rate. */
	UPROPERTY(VisibleAnywhere, BlueprintReadOnly, Category = Camera)
		float BaseLookUpRate;

protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

	/** Called for forwards/backward input */
	void MoveForward(float Value);

	/** Called for side to side input */
	void MoveRight(float Value);

	/**
	* Called via input to turn at a given rate.
	* @param Rate	This is a normalized rate, i.e. 1.0 means 100% of desired turn rate
	*/
	void TurnAtRate(float Rate);

	/**
	* Called via input to turn look up/down at a given rate.
	* @param Rate	This is a normalized rate, i.e. 1.0 means 100% of desired turn rate
	*/
	void LookUpAtRate(float Rate);


public:	
	// Called every frame
	virtual void Tick(float DeltaTime) override;

	// Called to bind functionality to input
	virtual void SetupPlayerInputComponent(class UInputComponent* PlayerInputComponent) override;

	/*Accessor function for initial score*/
	UFUNCTION(BlueprintPure, Category = "Score")
	float GetInitialScore();

	/*Accessor function for current score*/
	UFUNCTION(BlueprintPure, Category = "Score")
	float GetCurrentScore();

	/*Function to update character's score
	Can be negtive to decrease the character's score
	*/
	UFUNCTION(BlueprintCallable, Category = "Score")
	void UpdateScore(float ScoreChange);

protected:

	/*Return Collection Sphere Subobject*/
	FORCEINLINE class USphereComponent* GetCollectionSphere() const { return CollectionSphere; }

	/*Called when we press a key to collect any pellets inside the CollectionSphere*/
	UFUNCTION(BlueprintCallable, Category = "Pellets")
	void CollectPickUps();

	/*Starting Score*/
	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category = "Score", Meta = (BlueprintProtected = "true"))
	float InitialScore;

	/*Multiplier for character speed*/
	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category = "Score", Meta = (BlueprintProtected = "true"))
	float SpeedFactor;

	/*Character's speed at Score of zero*/
	UPROPERTY(EditAnywhere, BlueprintReadWrite, Category = "Score", Meta = (BlueprintProtected = "true"))
	float BaseSpeed;

	UFUNCTION(BlueprintImplementableEvent, Category = "Score")
	void ScoreChangeEffect();

private:
	/*Character Score Level*/
	UPROPERTY(VisibleAnywhere, Category = "Score")
	float CharacterScore;
};