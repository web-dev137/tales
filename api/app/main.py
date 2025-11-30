from fastapi import FastAPI 

app = FastAPI()

@app.get("/generate_story")
def ping():
    return {"status":"ok"}