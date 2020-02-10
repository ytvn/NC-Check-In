package com.example.login.Retrofit;

public class HTML {
    private String html;
    private String status;

    public HTML(String html, String status) {
        this.html = html;
        this.status = status;
    }

    public void setHtml(String html) {
        this.html = html;
    }

    public String getHtml() {
        return html;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
