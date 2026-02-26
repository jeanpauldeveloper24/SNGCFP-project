import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class MarcheService {
  final String baseUrl = "http://127.0.0.1:8000/api";

  Future<List<dynamic>> fetchMarches() async {
    final prefs = await SharedPreferences.getInstance();
    final response = await http.get(
      Uri.parse('$baseUrl/marches'),
      headers: {'Authorization': 'Bearer ${prefs.getString('auth_token')}'},
    );
    return response.statusCode == 200 ? jsonDecode(response.body) : [];
  }

  Future<bool> saveMarche(String objet, String procedure) async {
    final prefs = await SharedPreferences.getInstance();
    final response = await http.post(
      Uri.parse('$baseUrl/marches'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ${prefs.getString('auth_token')}'
      },
      body: jsonEncode({'objet': objet, 'procedure': procedure}),
    );
    return response.statusCode == 201;
  }
}