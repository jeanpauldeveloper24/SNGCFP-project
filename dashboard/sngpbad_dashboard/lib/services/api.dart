import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  
  final String baseUrl = "http://127.0.0.1:8000/api";
  
  // On stocke le token après le login (en prod, utilise flutter_secure_storage)
  static String? _token;

  // --- MÉTHODE DE CONNEXION ---
  Future<bool> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Accept': 'application/json'},
      body: {
        'email': email,
        'password': password,
        'device_name': 'windows_desktop', // Identifiant de la session
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      _token = data['token']; // On récupère le token Sanctum
      return true;
    } else {
      print("Erreur Login: ${response.body}");
      return false;
    }
  }

  // --- RÉCUPÉRATION DES PROJETS (SÉCURISÉE) ---
  Future<List<dynamic>> fetchProjects() async {
    if (_token == null) throw Exception('Non authentifié');

    final response = await http.get(
      Uri.parse('$baseUrl/projets'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $_token', // Envoi du Token obligatoire
      },
    );

    if (response.statusCode == 200) {
      return json.decode(response.body);
    } else {
      throw Exception('Erreur lors du chargement des projets');
    }
  }
}