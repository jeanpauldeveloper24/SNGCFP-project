import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:file_picker/file_picker.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:sngpbad_dashboard/models/user_model.dart'; 
import 'package:sngpbad_dashboard/services/auth.dart';

class Register extends StatefulWidget {
  const Register({super.key});

  @override
  State<Register> createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  final _formKey = GlobalKey<FormState>();
  final _nameController = TextEditingController();
  final _emailController = TextEditingController();
  final _phoneController = TextEditingController();
  final _passwordController = TextEditingController();
  
  String _selectedRole = 'representant_bad'; 
  File? _selectedImage; 
  bool _isObscured = true;
  bool _isLoading = false;

  final Color primaryBlue = const Color(0xFF1B4F72);

  final Map<String, String> roleLabels = {
    'representant_bad': "Représentant de la BAD",
    'ministre': "Ministre",
    'direction_nationale': "Direction nationale",
    'auditeur_externe': "Auditeur externe",
    'prestataire': "Prestataire",
  };

  Future<void> _pickImage() async {
    FilePickerResult? result = await FilePicker.platform.pickFiles(
      type: FileType.image,
    );

    if (result != null && result.files.single.path != null) {
      setState(() {
        _selectedImage = File(result.files.single.path!);
      });
    }
  }

  void _handleRegister() async {
    if (_formKey.currentState!.validate()) {
      if (_selectedImage == null) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text("La photo est obligatoire"), backgroundColor: Colors.orange),
        );
        return;
      }

      setState(() => _isLoading = true);

      try {
        final authService = AuthService();

        // 1. Conversion de l'image
        List<int> imageBytes = await _selectedImage!.readAsBytes();
        String base64Image = base64Encode(imageBytes);

        // 2. Préparation des infos
        String description = roleLabels[_selectedRole] ?? "";
        String platform = (_selectedRole == 'admin' || _selectedRole == 'comptable_bad') 
            ? 'laravel_web' 
            : 'flutter_desktop';

        // 3. Création de l'objet initial
        final newUser = UserModel(
          id: '', 
          name: _nameController.text.trim(),
          email: _emailController.text.trim(),
          password: _passwordController.text,
          phone: _phoneController.text.trim(),
          photo: base64Image,
          status: "actif",
          created_by: "Self-Register",
          created_at: DateTime.now(),
          updated_at: DateTime.now(),
          roleName: _selectedRole,
          roleDescription: description,
          platform: platform,
        );

        // 4. Appel au service et récupération de l'ID Firebase
        final String? firebaseId = await authService.register(newUser);

        if (!mounted) return;

        if (firebaseId != null && firebaseId.isNotEmpty) {
          final prefs = await SharedPreferences.getInstance();
          
          // Sauvegarde locale de la session
          await prefs.setString('user_session_id', firebaseId);
          await prefs.setBool('is_logged_in', true);
          
          // On crée l'utilisateur final avec son ID réel pour le passer au Dashboard
          final authenticatedUser = newUser.copyWith(id: firebaseId, password: '');

          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text("Inscription réussie !"), backgroundColor: Colors.green),
          );

          // LOG DE VÉRIFICATION
          print("Session active pour : $firebaseId");

          // Redirection vers le dashboard avec l'utilisateur complet en argument
          Navigator.pushReplacementNamed(
            context, 
            '/dashboard', 
            arguments: authenticatedUser
          );
        } else {
          throw Exception("L'ID Firebase n'a pas pu être récupéré.");
        }
      } catch (e) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text("Erreur : ${e.toString()}"), backgroundColor: Colors.red),
        );
      } finally {
        if (mounted) setState(() => _isLoading = false);
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(vertical: 40),
          child: Container(
            width: 450,
            padding: const EdgeInsets.all(40),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(16),
              boxShadow: const [BoxShadow(color: Colors.black12, blurRadius: 20)],
            ),
            child: Form(
              key: _formKey,
              child: Column(
                children: [
                  Text(
                    "Inscription SNGP-BAD", 
                    style: GoogleFonts.montserrat(fontSize: 22, fontWeight: FontWeight.bold, color: primaryBlue)
                  ),
                  const SizedBox(height: 25),
                  
                  GestureDetector(
                    onTap: _pickImage,
                    child: Stack(
                      children: [
                        CircleAvatar(
                          radius: 50,
                          backgroundColor: Colors.grey[200],
                          backgroundImage: _selectedImage != null ? FileImage(_selectedImage!) : null,
                          child: _selectedImage == null ? Icon(Icons.camera_alt, color: primaryBlue, size: 30) : null,
                        ),
                        Positioned(
                          bottom: 0,
                          right: 0,
                          child: CircleAvatar(
                            radius: 15, 
                            backgroundColor: primaryBlue, 
                            child: const Icon(Icons.add, size: 18, color: Colors.white)
                          ),
                        )
                      ],
                    ),
                  ),
                  const SizedBox(height: 30),

                  _buildField(_nameController, "Nom complet", Icons.badge_outlined),
                  const SizedBox(height: 20),
                  _buildField(_emailController, "Email", Icons.email_outlined),
                  const SizedBox(height: 20),
                  _buildField(_phoneController, "Téléphone", Icons.phone_android),
                  const SizedBox(height: 20),
                  
                  DropdownButtonFormField<String>(
                    value: _selectedRole,
                    decoration: InputDecoration(
                      labelText: "Rôle / Institution",
                      prefixIcon: Icon(Icons.account_tree_outlined, color: primaryBlue),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                    ),
                    items: roleLabels.entries.map((e) => DropdownMenuItem(value: e.key, child: Text(e.value))).toList(),
                    onChanged: (val) => setState(() => _selectedRole = val!),
                  ),
                  const SizedBox(height: 20),
                  
                  TextFormField(
                    controller: _passwordController,
                    obscureText: _isObscured,
                    decoration: InputDecoration(
                      labelText: "Mot de passe",
                      prefixIcon: Icon(Icons.lock_outline, color: primaryBlue),
                      suffixIcon: IconButton(
                        icon: Icon(_isObscured ? Icons.visibility : Icons.visibility_off),
                        onPressed: () => setState(() => _isObscured = !_isObscured),
                      ),
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                    ),
                    validator: (v) => (v == null || v.length < 6) ? "6 caractères min." : null,
                  ),
                  const SizedBox(height: 35),
                  
                  SizedBox(
                    width: double.infinity,
                    height: 55,
                    child: ElevatedButton(
                      onPressed: _isLoading ? null : _handleRegister,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: primaryBlue, 
                        foregroundColor: Colors.white,
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))
                      ),
                      child: _isLoading 
                        ? const CircularProgressIndicator(color: Colors.white) 
                        : const Text("S'INSCRIRE", style: TextStyle(fontWeight: FontWeight.bold)),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildField(TextEditingController controller, String label, IconData icon) {
    return TextFormField(
      controller: controller,
      decoration: InputDecoration(
        labelText: label,
        prefixIcon: Icon(icon, color: primaryBlue),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
      ),
      validator: (v) => (v == null || v.isEmpty) ? "Requis" : null,
    );
  }
}