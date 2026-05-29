# pyrefly: ignore [missing-import]
from django.shortcuts import render
# pyrefly: ignore [missing-import]
from django.http import HttpResponse


def home_page_view(request):
    return HttpResponse("Hello, World!")