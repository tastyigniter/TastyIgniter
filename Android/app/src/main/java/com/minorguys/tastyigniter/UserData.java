package com.minorguys.tastyigniter;

/**
 * Created by amazingshuttler on 26/9/17.
 */

public class UserData {
    static String fname="";
    static String lname;
    static String answer;
    static String pin;
    static String state,city ;
    static String password, mobile, address1 , address2 , email;
    static String country;
    static String id;
    static String qid;
    static String question;
    static boolean status=false;

    public boolean getstatus()
    {
        return status;
    }
    public void setstatus(boolean x)
    {
        status=x;
    }

    public String getFname() {
        return fname;
    }

    public String getLname() {
        return lname;
    }

    public String getAnswer() {
        return answer;
    }

    public String getPin() {
        return pin;
    }

    public String getState() {
        return state;
    }

    public String getCity() {
        return city;
    }

    public String getPassword() {
        return password;
    }

    public String getMobile() {
        return mobile;
    }

    public String getAddress1() {
        return address1;
    }

    public String getAddress2() {
        return address2;
    }

    public String getEmail() {
        return email;
    }

    public String getCountry() {
        return country;
    }

    public String getId() {
        return id;
    }

    public String getQid() {
        return qid;
    }

    public String getQuestion() {
        return question;
    }

    public void setFname(String fname) {
        this.fname = fname;
    }

    public void setLname(String lname) {
        this.lname = lname;
    }

    public void setAnswer(String answer) {
        this.answer = answer;
    }

    public void setPin(String pin) {
        this.pin = pin;
    }

    public void setState(String state) {
        this.state = state;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public void setMobile(String mobile) {
        this.mobile = mobile;
    }

    public void setAddress1(String address1) {
        this.address1 = address1;
    }

    public void setAddress2(String address2) {
        this.address2 = address2;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setCountry(String country) {
        this.country = country;
    }

    public void setId(String id) {
        this.id = id;
    }

    public void setQid(String qid) {
        this.qid = qid;
    }

    public void setQuestion(String question) {
        this.question = question;
    }
}
