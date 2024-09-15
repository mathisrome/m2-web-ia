from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from sklearn.linear_model import LinearRegression
from loguru import logger
import uvicorn
import numpy as np
import pandas as pd

# Initialisation de FastAPI
app = FastAPI()

# Définition d'un modèle pour les données d'entrée


class PredictionData(BaseModel):
    surface: float


# Initialisation du modèle de régression linéaire
model = LinearRegression()

# Variable pour vérifier si le modèle est entraîné
is_model_trained = False

# Endpoint pour entraîner le modèle


@app.post("/train")
async def train():
    global is_model_trained

    # Lire le fichier CSV
    df = pd.read_csv('./apartment.csv')

    # Extraction des variables indépendantes et dépendantes
    X = df[['surface']]  # Variable explicative (surface)
    y = df['price']  # Variable cible (prix)

    # Entraînement du modèle
    model.fit(X, y)

    # Marquer le modèle comme entraîné
    is_model_trained = True

    # Logging avec Loguru
    logger.info("Modèle entraîné avec succès.")
    logger.info(f"Coefficients: {model.coef_}, Intercept: {model.intercept_}")

    return {"message": "Modèle entraîné avec succès."}

# Endpoint pour prédire un prix en fonction des données d'entrée


@app.post("/predict")
async def predict(data: PredictionData):
    global is_model_trained

    # Vérifier si le modèle a été entraîné
    if not is_model_trained:
        raise HTTPException(
            status_code=400, detail="Le modèle n'est pas encore entraîné. Veuillez entraîner le modèle d'abord.")

    X_new = np.array([[data.surface]])

    # Prédire le prix
    predicted_price = model.predict(X_new)[0]

    # Logging avec Loguru
    logger.info(f"Prédiction faite pour surface: {data.surface}")
    logger.info(f"Prix prédit: {predicted_price}")

    return {"predicted_price": predicted_price}

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=5000)
