# Create your views here.
# pyrefly: ignore [missing-import]
from django.http import HttpResponse
# pyrefly: ignore [missing-import]
from django.shortcuts import render

def home_page_view(request):
	return HttpResponse("Homepage")

def about_page_view(request):
	context = {
		"name": "Bahlil",
		"age": 49,
	}
	return render(request, "pages/about.html", context)