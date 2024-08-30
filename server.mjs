import express from 'express';
import fetch from 'node-fetch';

const app = express();

const API_KEY = '27a351758a8c62270b7dad656c728ee0c2d9ecc855b28e1eeb574008de2d4a4e';

app.get('/api/news', async (req, res) => {
    try {
        const response = await fetch(`https://serpapi.com/search.json?q=Benin+news&location=Benin&hl=fr&gl=fr&tbm=nws&api_key=${API_KEY}`);
        const data = await response.json();
        res.json(data);
    } catch (error) {
        res.status(500).json({ error: 'Une erreur est survenue lors de la récupération des nouvelles.' });
    }
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Serveur en fonctionnement sur le port ${PORT}`));
