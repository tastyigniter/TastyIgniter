package com.minorguys.tastyigniter;

/**
 * Created by hp-u on 25-09-2017.
 */

public class Mydata
{
    private String name, item_id,description,image_url,quantity,price;
    private  int t=0;

    public Mydata(String name, String item_id, String description, String image_url, String quantity, String price,int t) {
        this.name = name;
        this.item_id = item_id;
        this.description = description;
        this.image_url = image_url;
        this.quantity = quantity;
        this.price = price;
        this.t=t;
    }
    public Mydata()
    {

    }

    public int getT() {
        return t;
    }

    public void setT(int t) {
        this.t = t;
    }
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getItem_id() {
        return item_id;
    }

    public void setItem_id(String item_id) {
        this.item_id = item_id;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getImage_url() {
        return image_url;
    }

    public void setImage_url(String image_url) {
        this.image_url = image_url;
    }

    public String getQuantity() {
        return quantity;
    }

    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }
    public  String getm(String x)
    {
        return name;
    }
}
