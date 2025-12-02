from fastapi import FastAPI 
from google import genai
from pydantic import BaseModel

app = FastAPI()

class StoryRequest(BaseModel):
    lang: str
    characters: list[str]
    age: int

class StoryResponse(BaseModel):
    story: str

@app.post("/generate_story/", response_model=StoryResponse)
async def getStory(story: StoryRequest):
    languages = {"ru":"русском","kk":"казахском"}
    promt = "Напиши небольшую сказку на "+story.lang+" языке для ребёнка возраста %d лет"%story.age+" с участием следующих персонажей: "+", ".join(story.characters)
    promptSetting  = "Каждое предложение должно быть с новой строки.Количество массимально 250 слов."
    client = genai.Client()
    response = client.models.generate_content(
        model = "gemini-2.5-flash",
        contents = promt+"\n"+promptSetting
    )
    
    text = getattr(response, "text", None)
    if text is None:
        try:
            text = response.output[0].content[0].text
        except Exception:
            text = str(response)
            
    return {"story":text}