import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Messages extends StatefulWidget {
  const Messages({super.key});

  @override
  State<Messages> createState() => _MessagesState();
}

class _MessagesState extends State<Messages> {
  final Color primaryBlue = const Color(0xFF1B4F72);

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        // LISTE DES DISCUSSIONS (GAUCHE)
        Expanded(
          flex: 3,
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white,
              border: Border.all(color: Colors.black12),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Column(
              children: [
                _buildSearchBox(),
                Expanded(
                  child: ListView(
                    children: [
                      _buildChatTile("Jean Dupont", "Audit Lot 4 : Manque de justificatifs", "10:45", true),
                      _buildChatTile("Direction Budget", "Validation du rapport trimestriel", "Hier", false),
                      _buildChatTile("Expert Technique", "Photos de l'avancement du pont", "Lun.", false),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
        const SizedBox(width: 20),
        // FENÊTRE DE CHAT (DROITE)
        Expanded(
          flex: 7,
          child: Container(
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12),
              border: Border.all(color: Colors.black12),
            ),
            child: _buildChatWindow(),
          ),
        ),
      ],
    );
  }

  Widget _buildChatTile(String name, String lastMsg, String time, bool unread) {
    return ListTile(
      leading: CircleAvatar(backgroundColor: primaryBlue.withOpacity(0.1), child: Text(name[0])),
      title: Text(name, style: GoogleFonts.inter(fontWeight: unread ? FontWeight.bold : FontWeight.normal)),
      subtitle: Text(lastMsg, maxLines: 1, overflow: TextOverflow.ellipsis, style: const TextStyle(fontSize: 12)),
      trailing: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(time, style: const TextStyle(fontSize: 10)),
          if (unread) const Icon(Icons.circle, size: 10, color: Colors.blue),
        ],
      ),
    );
  }

  Widget _buildChatWindow() {
    return Column(
      children: [
        // Header du chat
        Padding(
          padding: const EdgeInsets.all(15),
          child: Row(
            children: [
              const CircleAvatar(radius: 15, child: Icon(Icons.person, size: 20)),
              const SizedBox(width: 10),
              Text("Jean Dupont (Auditeur Externe)", style: GoogleFonts.inter(fontWeight: FontWeight.bold)),
            ],
          ),
        ),
        const Divider(height: 1),
        // Zone des messages
        Expanded(
          child: ListView(
            padding: const EdgeInsets.all(20),
            children: [
              _bubble("Bonjour, j'ai besoin des factures pour le lot 4.", false),
              _bubble("Bien reçu, je vous envoie ça d'ici demain.", true),
            ],
          ),
        ),
        // Input de texte
        _buildMessageInput(),
      ],
    );
  }

  Widget _bubble(String text, bool isMe) {
    return Align(
      alignment: isMe ? Alignment.centerRight : Alignment.centerLeft,
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 5),
        padding: const EdgeInsets.all(12),
        decoration: BoxDecoration(
          color: isMe ? primaryBlue : Colors.grey[200],
          borderRadius: BorderRadius.circular(15),
        ),
        child: Text(text, style: TextStyle(color: isMe ? Colors.white : Colors.black87)),
      ),
    );
  }

  Widget _buildMessageInput() {
    return Padding(
      padding: const EdgeInsets.all(15),
      child: Row(
        children: [
          Expanded(
            child: TextField(
              decoration: InputDecoration(
                hintText: "Votre message...",
                fillColor: Colors.grey[100],
                filled: true,
                border: OutlineInputBorder(borderRadius: BorderRadius.circular(30), borderSide: BorderSide.none),
              ),
            ),
          ),
          const SizedBox(width: 10),
          FloatingActionButton(
            onPressed: () {},
            mini: true,
            backgroundColor: primaryBlue,
            child: const Icon(Icons.send, size: 18),
          ),
        ],
      ),
    );
  }

  Widget _buildSearchBox() {
    return Padding(
      padding: const EdgeInsets.all(10),
      child: TextField(
        decoration: InputDecoration(
          hintText: "Rechercher un contact",
          prefixIcon: const Icon(Icons.search, size: 20),
          border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
        ),
      ),
    );
  }
}