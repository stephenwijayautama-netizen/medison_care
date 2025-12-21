import dotenv from "dotenv";
import { GoogleGenerativeAI } from "@google/generative-ai";

dotenv.config();

const genAI = new GoogleGenerativeAI({
    apiKey: process.env.GEMINI_API_KEY,
});

async function main() {
    try {
        console.log("API KEY:", process.env.GEMINI_API_KEY ? "✅ Terdeteksi" : "❌ Tidak ada");

        const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
        const result = await model.generateContent("Halo Gemini, tes koneksi!");
        console.log(result.response.text());
    } catch (error) {
        console.error("Terjadi kesalahan:", error);
    }
}
console.log("API Key dari .env:", process.env.GEMINI_API_KEY);

main();